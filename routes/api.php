<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\TaskController;

Route::prefix('auth')->group(function () {

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // user
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::put('/profile', [AuthController::class, 'updateProfile']);
    Route::post('/me/profile-photo', [AuthController::class, 'storeProfilePhoto']);

// notes
    Route::get('/notes', [NoteController::class, 'index']);
    Route::get('/my-notes', [NoteController::class, 'myNotes']);
    Route::post('/notes', [NoteController::class, 'store']);
    Route::get('/notes/{note}', [NoteController::class, 'show']);
    Route::patch('/notes/{note}', [NoteController::class, 'update']);
    Route::delete('/notes/{note}', [NoteController::class, 'destroy']);

    Route::patch('/notes/{note}/publish', [NoteController::class, 'publish']);
    Route::patch('/notes/{note}/archive', [NoteController::class, 'archive']);
    Route::patch('/notes/{note}/pin', [NoteController::class, 'pin']);
    Route::patch('/notes/{note}/unpin', [NoteController::class, 'unpin']);

// tasks
    Route::apiResource('notes.tasks', TaskController::class)->scoped();

// comments
    Route::get('/notes/{note}/comments', [CommentController::class, 'indexNote']);
    Route::post('/notes/{note}/comments', [CommentController::class, 'storeNote']);
    Route::patch('/comments/{comment}', [CommentController::class, 'update']);
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy']);

// attachments
    Route::get('/notes/{note}/attachments', [AttachmentController::class, 'index']);
    Route::post('/notes/{note}/attachments', [AttachmentController::class, 'store'])
->middleware('premium');

Route::get('/attachments/{attachment}/link', [AttachmentController::class, 'link']);
});
});

?>
