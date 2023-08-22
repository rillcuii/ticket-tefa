<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\authController;
use App\Http\Controllers\tiketController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/',function(){
    return response()->json([
        'status' => false,
        'message' => 'Maaf Akses Di Batasi'
    ], 401);
})->name('login');

Route::get('ticket',[tiketController::class,'index'])->middleware('auth:sanctum','ability:teknisi');

Route::post('ticket',[tiketController::class,'store'])->middleware('auth:sanctum','ability:admin');


Route::post('registerUser',[authController::class,'registerUser']);

Route::post('loginUser',[authController::class,'loginUser']);
Route::post('logout',[authController::class,'logout'])->middleware('auth:sanctum');
Route::post('registerTeknisi',[authController::class,'registerTeknisi'])->middleware('auth:sanctum','ability:admin');;
Route::put('updateTeknisi/{id}',[authController::class,'updateTeknisi'])->middleware('auth:sanctum','ability:admin');;
