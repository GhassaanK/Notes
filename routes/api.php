<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/notes', [NoteController::class, 'store'])->middleware('auth:sanctum');

Route::get('/notes', [NoteController::class, 'index'])->middleware('auth:sanctum');

Route::get('/notes/{id}', [NoteController::class, 'show'])->middleware('auth:sanctum');

Route::put('/notes/{id}', [NoteController::class, 'update'])->middleware('auth:sanctum');

Route::delete('/notes/{id}', [NoteController::class, 'destroy'])->middleware('auth:sanctum');
