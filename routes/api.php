<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('auth/login', [AuthController::class, 'login']);
Route::get('hotels', [\App\Http\Controllers\Api\HotelController::class, 'index'])->middleware('auth:sanctum');
Route::post('hotels', [\App\Http\Controllers\Api\HotelController::class, 'store'])->middleware('auth:sanctum');
Route::get('hotels/{id}', [\App\Http\Controllers\Api\HotelController::class, 'show'])->middleware('auth:sanctum');
Route::patch('hotels/{id}', [\App\Http\Controllers\Api\HotelController::class, 'update'])->middleware('auth:sanctum');
Route::delete('hotels/{id}', [\App\Http\Controllers\Api\HotelController::class, 'destroy'])->middleware('auth:sanctum');


