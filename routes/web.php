<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;

Route::get('/', fn () => redirect('/rooms'));  // redirige por path, SIN usar nombre

// Si quieres proteger con login:
Route::middleware('auth')->group(function () {
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::resource('rooms', RoomController::class)->except(['index']);
    Route::get('/dashboard', fn () => redirect('/rooms'))->name('dashboard');
});

// Si quieres que /rooms sea público, usa esto en cambio:
// Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
// Route::resource('rooms', RoomController::class)->except(['index']);
// Route::get('/dashboard', fn () => redirect('/rooms'))->middleware('auth')->name('dashboard');

require __DIR__.'/auth.php'; // <<— importante, Breeze define aquí /login y /register

