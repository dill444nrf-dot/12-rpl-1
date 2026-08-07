<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GenreController;
use App\Http\Controllers\Api\AktorController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FilmController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    //route Genre
    Route::get('/genre',[GenreController::class,'index']);
    Route::post('/genre',[GenreController::class,'store']);
    Route::put('/genre/{id}',[GenreController::class,'update']);
    Route::delete('/genre/{id}',[GenreController::class,'destroy']);

    //route Aktor
     Route::get('/aktor',[AktorController::class,'index']);
     Route::post('/aktor',[AktorController::class,'store']);
    Route::put('/aktor/{id}',[AktorController::class,'update']);
    Route::delete('/aktor/{id}',[AktorController::class,'destroy']);

    //route Film
    Route::get('/films',[FilmController::class,'index']);
    Route::post('/films',[FilmController::class,'store']);
    Route::get('/films/{id}',[FilmController::class,'show']);
    Route::put('/films/{id}',[FilmController::class,'update']);
    Route::delete('/films/{id}',[FilmController::class,'destroy']);

});