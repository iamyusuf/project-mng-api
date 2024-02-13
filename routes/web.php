<?php

use App\Classes\Registry;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/cache', function () {
   return Cache::get('key');
});

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('/match', [\App\Http\Controllers\HomeController::class, 'matches']);
Route::get('/fiber', [\App\Http\Controllers\HomeController::class, 'fiber']);
Route::get('/reflect', [\App\Http\Controllers\HomeController::class, 'reflect']);
Route::get('/reflect-class', [\App\Http\Controllers\HomeController::class, 'reflectClass']);
Route::get('/soap', [\App\Http\Controllers\HomeController::class, 'soapApi']);
Route::get('/users', [\App\Http\Controllers\HomeController::class, 'users']);

Route::get('/files', function () {
    return (new \App\Services\ReleaseService)->get();
});

require __DIR__.'/auth.php';
