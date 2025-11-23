<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewsController;
use App\Http\Controllers\Api\CategoryController;

Route::post('register', [AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);

// public
Route::get('news', [NewsController::class,'index']);
Route::get('news/{news}', [NewsController::class,'show']);
Route::get('categories', [CategoryController::class,'index']);
Route::get('categories/{category}', [CategoryController::class,'show']);

// protected
Route::middleware('auth:sanctum')->group(function(){
    Route::post('logout', [AuthController::class,'logout']);
    Route::get('me', [AuthController::class,'me']);

    // news (admin + author) - policy checks owner inside controller
    Route::post('news', [NewsController::class,'store'])->middleware('role:admin,author');
    Route::post('news/{news}', [NewsController::class,'update'])->middleware('role:admin,author'); // use POST if client cannot PUT; else use PUT
    Route::delete('news/{news}', [NewsController::class,'destroy'])->middleware('role:admin,author');

    // categories - only admin
    Route::post('categories', [CategoryController::class,'store'])->middleware('role:admin');
    Route::put('categories/{category}', [CategoryController::class,'update'])->middleware('role:admin');
    Route::delete('categories/{category}', [CategoryController::class,'destroy'])->middleware('role:admin');
});
