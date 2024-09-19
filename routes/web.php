<?php

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

Route::get('/', function () {
    return view('welcome');
});


  Route::get('/optimize', function() {
    Artisan::call('optimize');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('cache:clear');
    
    return 'Optimized and caches cleared!';
});
