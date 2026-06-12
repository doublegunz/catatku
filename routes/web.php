<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('home');
});

// Routes for guests (only accessible before login)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);

    // Add a login route
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// All routes that require login
Route::middleware('auth')->group(function () {

    // Add a route for logging out
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/entries', [EntryController::class, 'index']);
    Route::get('/entries/create', [EntryController::class, 'create']);
    Route::post('/entries', [EntryController::class, 'store']);
    Route::get('/entries/{entry}', [EntryController::class, 'show']);
    Route::get('/entries/{entry}/edit', [EntryController::class, 'edit']);
    Route::put('/entries/{entry}', [EntryController::class, 'update']);
    Route::delete('/entries/{entry}', [EntryController::class, 'destroy']);
});
