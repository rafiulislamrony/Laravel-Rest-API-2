<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

/*
|----------
| API Routes
|-----------
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('users/store', [UserController::class, 'store']);
Route::get('users/get', [UserController::class, 'index']);
