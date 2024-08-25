<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\MovieController;
use \App\Http\Controllers\RatingController;


Route::post('register',[UserController::class,'register']);
Route::post('login',[UserController::class,'login']);
Route::middleware('auth:sanctum')->group(function (){
    Route::post('logout',[UserController::class,'logout']);
    Route::apiResource('movies',MovieController::class);
    Route::apiResource('ratings',RatingController::class);
});
