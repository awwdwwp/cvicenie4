<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/notes/showten', [NoteController::class, 'showTen']);
Route::apiResource('/notes', NoteController::class);

Route::apiResource('/categories', CategoryController::class);
