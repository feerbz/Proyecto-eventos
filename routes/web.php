<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

Route::get('/schema-check', function () {

    return [
        'favorites_exists' => Schema::hasTable('favorites'),
        'admin_comment_exists' => Schema::hasColumn('events', 'admin_comment'),
        'migrations' => DB::table('migrations')
            ->orderByDesc('id')
            ->limit(10)
            ->get(),
    ];
});

Route::post(
    '/events/{id}/favorite',
    [EventController::class, 'favorite']
);

Route::delete(
    '/events/{id}/favorite',
    [EventController::class, 'unfavorite']
);

Route::get(
    '/favoritos',
    [EventController::class, 'favorites']
);
Route::get('/metricas', [EventController::class, 'metrics']);
Route::delete('/events/{id}/waitlist', [EventController::class, 'leaveWaitlist']);
Route::get(
    '/metricas/exportar',
    [EventController::class, 'exportMetrics']
);
Route::get(
    '/metricas/pdf',
    [EventController::class, 'exportMetricsPdf']
);
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

    Route::get(
    '/events/{id}/attendance',
    [EventController::class, 'attendanceForm']
);

Route::post(
    '/events/{id}/attendance',
    [EventController::class, 'registerAttendance']
);
Route::get(
    '/attendance',
    [EventController::class, 'attendanceIndex']
);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/create', [CategoryController::class, 'create']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
    Route::post('/events/{id}/waitlist', [EventController::class, 'joinWaitlist']);
    Route::get('/calendario', [EventController::class, 'calendar']);

    /* -------- ESPACIOS -------- */
    Route::get('/spaces/create', [SpaceController::class, 'create']);
    Route::post('/spaces', [SpaceController::class, 'store']);
    Route::get('/spaces', [SpaceController::class, 'index']);
    Route::get('/spaces/{id}/edit', [SpaceController::class, 'edit']);
    Route::put('/spaces/{id}', [SpaceController::class, 'update']);
    Route::delete('/spaces/{id}', [SpaceController::class, 'destroy']);

    /* -------- EVENTOS -------- */

    // RUTAS ESPECÍFICAS PRIMERO
    Route::get('/events/pending', [EventController::class, 'pending']);

    Route::get('/events/create', [EventController::class, 'create']);
    Route::post('/events', [EventController::class, 'store']);

    Route::get('/events', [EventController::class, 'index']);

    Route::get('/mis-eventos', [EventController::class, 'myEvents']);
    Route::get('/mis-inscripciones', [EventController::class, 'myRegistrations']);
    Route::get('/historial', [EventController::class, 'history']);

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

    Route::get('/event-image/{event}', function (\App\Models\Event $event) {
    if (!$event->image) {
        abort(404);
    }

    $path = storage_path('app/public/' . $event->image);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});


require __DIR__.'/auth.php';