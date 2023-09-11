<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Validated;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($flag)
    {
        // flag = 1(active)
        // flag = 0(all)
        //All users
        //Active
        $users = User::select('email', 'name')->where('status', 1)->get();

       if(count($users) > 0){
        $response = [
            'message' => count($users). ' Users Found',
            'status'=> 1,
            'data' => $users
        ];
       }else{
        $response = [
            'message' => count($users). ' Users Found',
            'status'=> 0,
        ];
       }
       return response()->json($response, 200);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'name'=> ['required'],
            'email'=> ['required', 'email', 'unique:users,email,'],
            'password'=> ['required','min:8','confirmed'],
            'password_confirmation'=> ['required'],
        ]);

        if($validator->fails()){
            return response()->json($validator->messages(), 400);
        }else{
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ];
            DB::beginTransaction();
            try{
              $user = User::create($data);
                DB::commit();
            }catch(\Exception $e){
                DB::rollBack();
                p($e->getMessage());
                $user = null;
            }

            if($user != null){
                return response()->json([
                    'message' =>'User Register Successfully.'
                ], 200);
            }else{
                return response()->json([
                    'message' =>'Internal Server Error.'
                ], 500);
            }

        }

        p($request->all());

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}