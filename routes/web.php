<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeadController;
use Illuminate\Support\Facades\Route;

// Public Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard (Protected)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Protected Routes (User Must Be Logged In)
Route::middleware('auth')->group(function () {

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // LEADS CRUD ROUTES
    Route::resource('leads', LeadController::class);
});

require __DIR__.'/auth.php';
