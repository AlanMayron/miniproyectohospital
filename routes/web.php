<?php
use App\Http\Controllers\RoomController;

Route::get('/', fn () => redirect()->route('rooms.index'));

Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

// Acciones de ocupación (misma página)
Route::post('/rooms/{room}/checkin', [RoomController::class, 'checkin'])->name('rooms.checkin');
Route::post('/rooms/{room}/checkout', [RoomController::class, 'checkout'])->name('rooms.checkout');

Route::get('/dashboard', fn () => redirect()->route('rooms.index'))->name('dashboard');
