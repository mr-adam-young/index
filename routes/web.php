<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LegacyController;
use App\Http\Controllers\JobController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// authenticated routes
Route::middleware('auth')->group(function () {

    Route::get('/board', fn() => view('board'))->name('board');

    Route::get('jobs/active', [JobController::class, 'active'])->name('jobs.active');
    Route::resource('jobs', JobController::class);

    // user profile stuff
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';