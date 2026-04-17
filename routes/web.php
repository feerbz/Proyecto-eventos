<?php 

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;

Route::get('/events', [EventController::class,'index']);
Route::post('/events', [EventController::class, 'store'])->middleware('auth');

Route::post('/events/{id}/approve', [EventController::class, 'approve'])->middleware('auth');
Route::post('/events/{id}/reject', [EventController::class, 'reject'])->middleware('auth');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [EventController::class, 'feed'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('/events/create', function () {
    return view('events.create');
})->middleware('auth');

Route::get('/mis-eventos', [EventController::class, 'myEvents'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/events/pending', [EventController::class, 'pending'])->middleware('auth');
Route::get('/events/{id}/edit', [EventController::class, 'edit'])->middleware('auth');
Route::put('/events/{id}', [EventController::class, 'update'])->middleware('auth');
Route::delete('/events/{id}', [EventController::class, 'destroy'])->middleware('auth');

require __DIR__.'/auth.php';
