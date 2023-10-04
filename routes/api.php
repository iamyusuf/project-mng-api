<?php

use App\Http\Controllers\AuthController;
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

Route::post('login', [AuthController::class, 'login']);

Route::get('projects', [\App\Http\Controllers\ProjectController::class, 'projects']);
Route::post('projects', [\App\Http\Controllers\ProjectController::class, 'store']);
Route::put('projects/{project}', [\App\Http\Controllers\ProjectController::class, 'update']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
