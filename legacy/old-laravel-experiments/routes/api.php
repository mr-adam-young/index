<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// per JWT tutorial
use App\Http\Controllers\APIController;
use App\Http\Controllers\CostCenterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [APIController::class, 'authenticate']);
Route::post('register', [APIController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::get('logout', [APIController::class, 'logout']);
    Route::get('get_user', [APIController::class, 'get_user']);
    Route::get('cost_centers', [CostCenterController::class, 'index']);
    Route::get('cost/{id}', [CostCenterController::class, 'show']);
    Route::post('create', [CostCenterController::class, 'store']);
    Route::put('update/{cost_center}',  [CostCenterController::class, 'update']);
    Route::delete('delete/{cost_center}',  [CostCenterController::class, 'destroy']);
});