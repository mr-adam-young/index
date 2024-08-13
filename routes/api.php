<?php

// dd('API routes loaded');

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaborController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/clockshark', [LaborController::class, 'store']);

Route::get('/test', function () {
    return response()->json(['message' => 'Test route']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
