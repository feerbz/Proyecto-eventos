<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpaceController;

Route::delete('/events/{id}/waitlist', [EventController::class, 'leaveWaitlist']);

/* ---------------- PUBLICO ---------------- */
Route::get('/', function () {
    return view('welcome');
});

/* ---------------- DASHBOARD ---------------- */
Route::get('/dashboard', [EventController::class, 'feed'])
    ->middleware('auth')
    ->name('dashboard');

/* ---------------- RUTAS AUTENTICADAS ---------------- */
Route::middleware('auth')->group(function () {

    Route::post('/events/{id}/waitlist', [EventController::class, 'joinWaitlist']);

    /* -------- ESPACIOS -------- */
    Route::get('/spaces/create', [SpaceController::class, 'create']);
    Route::post('/spaces', [SpaceController::class, 'store']);

    /* -------- EVENTOS -------- */

    // RUTAS ESPECÍFICAS PRIMERO
    Route::get('/events/pending', [EventController::class, 'pending']);

    Route::get('/events/create', [EventController::class, 'create']);
    Route::post('/events', [EventController::class, 'store']);

    Route::get('/events', [EventController::class, 'index']);

    Route::get('/mis-eventos', [EventController::class, 'myEvents']);
    Route::get('/mis-inscripciones', [EventController::class, 'myRegistrations']);

    // ACCIONES ADMIN
    Route::post('/events/{id}/approve', [EventController::class, 'approve']);
    Route::post('/events/{id}/reject', [EventController::class, 'reject']);

    // INSCRIPCIONES
    Route::post('/events/{id}/register', [EventController::class, 'register']);
    Route::delete('/events/{id}/unregister', [EventController::class, 'unregister']);

    // CRUD EVENTOS
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');

    Route::get('/events/{id}/edit', [EventController::class, 'edit']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);

    /* -------- PERFIL -------- */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
Route::get('/test-public-file', function () {

    $event = \App\Models\Event::whereNotNull('image')->latest()->first();

    return [
        'image' => $event->image,
        'public_file_exists' => file_exists(
            public_path('storage/' . $event->image)
        ),
        'public_path' => public_path('storage/' . $event->image),
    ];
});





