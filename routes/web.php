<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
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

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/files', function () {
    return (new \App\Services\ReleaseService)->get();
});

require __DIR__.'/auth.php';
