<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('properties', PropertyController::class)->names('properties');
        // ->middleware('can:manage-properties')
        // ->except(['show']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // ->name('dashboard.index')
        // ->middleware('can:manage-properties');
});

require __DIR__.'/auth.php';
