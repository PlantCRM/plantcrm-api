<?php

use App\Http\Controllers\Api\V1\Auth;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('auth/register', Auth\RegisterController::class);
Route::post('auth/login', Auth\LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', Auth\LogoutController::class);

    Route::get('users', [UserController::class, 'index']);
    Route::post('users/create', [UserController::class, 'create']);
    Route::get('users/{name}', [UserController::class, 'show']);
    Route::put('users/{name}', [UserController::class, 'update']);
    Route::delete('users/{name}', [UserController::class, 'delete']);
});
