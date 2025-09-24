<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

Route::get('/', fn() => redirect()->route('rooms.index'));
Route::resource('rooms', RoomController::class);
Route::post('rooms/{id}/restore', [\App\Http\Controllers\RoomController::class, 'restore'])
    ->name('rooms.restore');
Route::delete('rooms/{id}/force', [\App\Http\Controllers\RoomController::class, 'forceDelete'])
    ->name('rooms.force-delete');
Route::middleware('auth')->group(function () {
    Route::resource('rooms', RoomController::class);
    Route::post('rooms/{id}/restore', [RoomController::class, 'restore'])->name('rooms.restore');
    Route::delete('rooms/{id}/force', [RoomController::class, 'forceDelete'])->name('rooms.force-delete');
});
