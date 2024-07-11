<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* routes to legacy PHP scripts */
Route::get('/legacy/{filename}', function ($filename) {
    $file = base_path('legacy/' . $filename . '.php');

    if (file_exists($file)) {
        ob_start();
        include $file;
        return ob_get_clean();
    }

    abort(404, 'File not found');
})->where('filename', '.*');

require __DIR__.'/auth.php';
