<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CommentController;

Route::get('/', function () {
    return view('home');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware(['auth', 'log.request'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/entries/trash', [EntryController::class, 'trash'])->name('entries.trash');
    Route::resource('entries', EntryController::class);
    Route::patch('/entries/{entry}/restore', [EntryController::class, 'restore'])
        ->name('entries.restore')
        ->withTrashed();

    Route::post('/entries/{entry}/comments', [CommentController::class, 'store'])
        ->name('comments.store')
        ->middleware('throttle:10,1');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
    Route::get('/tags/{tag:slug}', [TagController::class, 'show'])->name('tags.show');
});
