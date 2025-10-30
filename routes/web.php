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

    Route::get('/dashboard/task', [TaskController::class, 'index'])->name('task.index');
    // Route::get('/dashboard/task', [TaskController::class, 'create'])->name('task.create');
    Route::get('/dashboard/task/{id}', [TaskController::class, 'edit'])->name('task.edit'); //affiche le formulaire de modification à partir de l'id
    Route::post('/dashboard/task/{id}', [TaskController::class, 'store'])->name('task.store'); // enregistre à partir de l'id
    Route::put('/dashboard/task/{id}', [TaskController::class, 'update'])->name('task.update'); // met à jour à partir de l'id 
    Route::delete('/dashboard/task/{id}', [TaskController::class, 'destroy'])->name('task.destroy'); // supprime à partir de l'id
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
