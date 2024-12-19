<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware(['auth:sanctum'])->group(
    function(){
        Route::apiResource('books',BookController::class);

        Route::apiResource('authors',AuthorController::class);

        Route::get('author/search',[AuthorController::class,'search']);
    }
);

Route::post('/auth/login',[AuthController::class,'login']);
Route::post('/auth/register',[AuthController::class,'register']);
Route::post('/auth/logout',[AuthController::class,'logout'])->middleware('auth:sanctum');
