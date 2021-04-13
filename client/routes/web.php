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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/freeresources', function () {
    return view('freeresources');
});


Route::get('/oauth/redirect', [App\Http\Controllers\OAuthController::class, 'redirect']);

Route::get('/oauth/callback', [App\Http\Controllers\OAuthController::class, 'callback']);
Route::get('/userresources', [App\Http\Controllers\OAuthController::class, 'user']);
Route::get('/oauth/logout', [App\Http\Controllers\OAuthController::class, 'logout']);
