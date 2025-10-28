<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/auth', [AuthController::class, 'index'])->name('auth.index');
    Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
    Route::get('/tasks', [TaskController::class, 'create'])->name('tasks.create');
    Route::get('/tasks/{id}', [TaskController::class, 'edit'])->name('tasks.edit'); //affiche le formulaire de modification à partir de l'id
    Route::post('/tasks/{id}', [TaskController::class, 'store'])->name('tasks.store'); // enregistre à partir de l'id
    Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update'); // met à jour à partir de l'id 
    Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy'); // supprime à partir de l'id
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
