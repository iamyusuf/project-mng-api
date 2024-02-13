<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\StoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('liveness', [HealthController::class, 'liveness']);
Route::get('readiness', [HealthController::class, 'readiness']);

Route::post('login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function() {
    Route::get('projects', [\App\Http\Controllers\ProjectController::class, 'projects']);
    Route::post('projects', [\App\Http\Controllers\ProjectController::class, 'store']);
    Route::put('projects/{project}', [\App\Http\Controllers\ProjectController::class, 'update']);

    Route::post('{project}/stories', [StoryController::class, 'create']);
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
