<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;

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

    Route::get('/entries', [EntryController::class, 'index'])->name('entries.index');
    Route::get('/entries/create', [EntryController::class, 'create'])->name('entries.create');
    Route::post('/entries', [EntryController::class, 'store'])->name('entries.store');
    Route::get('/entries/trash', [EntryController::class, 'trash'])->name('entries.trash'); // must be here, before {entry}
    Route::get('/entries/{entry}', [EntryController::class, 'show'])->name('entries.show');
    Route::get('/entries/{entry}/edit', [EntryController::class, 'edit'])->name('entries.edit');
    Route::put('/entries/{entry}', [EntryController::class, 'update'])->name('entries.update');
    Route::delete('/entries/{entry}', [EntryController::class, 'destroy'])->name('entries.destroy');
    Route::patch('/entries/{entry}/restore', [EntryController::class, 'restore'])
        ->name('entries.restore')
        ->withTrashed();

    Route::post('/entries/{entry}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
});
