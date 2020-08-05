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

Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');

Route::post('logout', 'Auth\LoginController@logout')->name('logout');

Route::middleware('auth')->group(function() {
    Route::get('login-to-environment')->uses(LoginToEnvironmentController::class . '@index')->name('login-to-environment.index');
    Route::post('login-to-environment')->uses(LoginToEnvironmentController::class . '@store')->name('login-to-environment.store');
    Route::get('setup-environment')->uses(SetupEnvironmentController::class . '@show')->name('setup-environment.show');
    Route::post('setup-environment')->uses(SetupEnvironmentController::class . '@store')->name('setup-environment.store');
});
