<?php 

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

// --- RUTAS PÚBLICAS / DASHBOARD ---
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [EventController::class, 'feed'])
    ->middleware(['auth'])
    ->name('dashboard');

// --- PANEL DE ADMINISTRACIÓN Y RUTAS FIJAS (ESTAS VAN PRIMERO) ---
Route::middleware('auth')->group(function () {
    // Movimos esto hacia arriba para que Laravel no lo confunda con un ID
    Route::get('/events/pending', [EventController::class, 'pending']);
    Route::get('/mis-eventos', [EventController::class, 'myEvents']);
    Route::get('/mis-inscripciones', [EventController::class, 'myRegistrations']);
});

// --- RUTAS DE EVENTOS (CRUD) ---
Route::middleware('auth')->group(function () {
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/create', function () { return view('events.create'); });
    Route::post('/events', [EventController::class, 'store']);
    
    // Al dejar esta al final de los GET, Laravel solo entrará aquí si no es "pending", "create", etc.
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    
    Route::get('/events/{id}/edit', [EventController::class, 'edit']);
    Route::put('/events/{id}', [EventController::class, 'update']);
    Route::delete('/events/{id}', [EventController::class, 'destroy']);
});

// --- ACCIONES DE FORMULARIO (POST/DELETE) ---
Route::middleware('auth')->group(function () {
    Route::post('/events/{id}/register', [EventController::class, 'register']);
    Route::delete('/events/{id}/unregister', [EventController::class, 'unregister']);
    Route::post('/events/{id}/approve', [EventController::class, 'approve']);
    Route::post('/events/{id}/reject', [EventController::class, 'reject']);
});

// --- PERFIL DE USUARIO ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';