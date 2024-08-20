<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LegacyController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// authenticated routes
Route::middleware('auth')->group(function () {

    Route::get('/jobs', fn() => view('jobs'))->name('jobs');

    Route::get('/board', fn() => view('board'))->name('board');

    Route::get('/jobs/{id}', function ($id) {
        return view('jobs', ['id' => $id]);
    })->name('jobs.show');

    // user profile stuff
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';