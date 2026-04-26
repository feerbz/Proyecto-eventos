<?php 

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

/*
|--------------------------------------------------------------------------
| UniEvent - Rutas de Producción
|--------------------------------------------------------------------------
*/

// --- RUTA PRINCIPAL ---
Route::get('/', function () {
    return view('welcome');
});

// --- DASHBOARD (FEED DE EVENTOS) ---
Route::get('/dashboard', [EventController::class, 'feed'])
    ->middleware(['auth'])
    ->name('dashboard');

// --- RUTAS AUTENTICADAS ---
Route::middleware('auth')->group(function () {
    
    // Panel de Administración (Solo para roles admin)
    Route::get('/events/pending', [EventController::class, 'pending']);
    
    // Gestión de Eventos del Usuario
    Route::get('/mis-eventos', [EventController::class, 'myEvents']);
    Route::get('/mis-inscripciones', [EventController::class, 'myRegistrations']);

    // CRUD de Eventos
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/create', function () { return view('events.create'); });
    Route::post('/events', [EventController::class, 'store']);
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{id}/edit', [EventController::class, 'edit']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);

    // Acciones de Inscripción y Moderación
    Route::post('/events/{id}/register', [EventController::class, 'register']);
    Route::delete('/events/{id}/unregister', [EventController::class, 'unregister']);
    Route::post('/events/{id}/approve', [EventController::class, 'approve']);
    Route::post('/events/{id}/reject', [EventController::class, 'reject']);

    // Perfil de Usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';