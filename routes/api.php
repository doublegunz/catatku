<?php

use App\Http\Controllers\Api\EntryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/entries', [EntryController::class, 'index']);
Route::get('/entries/{entry}', [EntryController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/entries', [EntryController::class, 'store']);
    Route::put('/entries/{entry}', [EntryController::class, 'update']);
    Route::delete('/entries/{entry}', [EntryController::class, 'destroy']);
});
