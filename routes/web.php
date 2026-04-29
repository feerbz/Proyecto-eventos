<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpaceController;

Route::middleware('auth')->group(function () {
    Route::get('/spaces/create', [SpaceController::class, 'create']);
    Route::post('/spaces', [SpaceController::class, 'store']);
});

/* ---------------- PUBLICO ---------------- */
Route::get('/', function () {
    return view('welcome');
});

/* ---------------- DASHBOARD ---------------- */
Route::get('/dashboard', [EventController::class, 'feed'])
    ->middleware('auth')
    ->name('dashboard');

/* ---------------- EVENTOS ---------------- */
Route::middleware('auth')->group(function () {

    //RUTAS ESPECÍFICAS PRIMERO
    Route::get('/events/pending', [EventController::class, 'pending']);

    Route::get('/events/create', [EventController::class, 'create']);
    Route::post('/events', [EventController::class, 'store']);

    Route::get('/events', [EventController::class, 'index']);

    Route::get('/mis-eventos', [EventController::class, 'myEvents']);
    Route::get('/mis-inscripciones', [EventController::class, 'myRegistrations']);

    //ACCIONES ADMIN (IMPORTANTE)
    Route::post('/events/{id}/approve', [EventController::class, 'approve']);
    Route::post('/events/{id}/reject', [EventController::class, 'reject']);

    //RUTAS DINÁMICAS AL FINAL
    Route::get('/events/{event}', [EventController::class, 'show']);

    Route::get('/events/{id}/edit', [EventController::class, 'edit']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);

    Route::post('/events/{id}/register', [EventController::class, 'register']);
    Route::delete('/events/{id}/unregister', [EventController::class, 'unregister']);
});

/* ---------------- PERFIL ---------------- */
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit']);
    Route::patch('/profile', [ProfileController::class, 'update']);
    Route::delete('/profile', [ProfileController::class, 'destroy']);
});

require __DIR__.'/auth.php';