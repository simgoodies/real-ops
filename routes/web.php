<?php

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

// Authentication Routes...
// Login and Logout Routes...
Route::get('login', 'Auth\User\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\User\LoginController@login');
Route::post('login-management', 'Auth\Admin\LoginController@login')->name('login-management');
Route::get('logout', 'Auth\User\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::get('password/reset', 'Auth\User\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\User\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\User\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\User\ResetPasswordController@reset');
Route::get('admin-password/reset', 'Auth\Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
Route::post('admin-password/email', 'Auth\Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
Route::get('admin-password/reset/{token}', 'Auth\Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
Route::post('admin-password/reset', 'Auth\Admin\ResetPasswordController@reset');

Route::get('apply', ['uses' => 'ApplicationController@create']);
Route::post('apply', ['uses' => 'ApplicationController@store', 'as' => 'applications.store']);
Route::get('successfully-applied', ['uses' => 'AppliedController@index', 'as' => 'applied.index']);

Route::get('airlines', ['uses' => 'AirlineController@index', 'as' => 'airlines.index']);
Route::post('airlines', 'AirlineController@store');

Route::name('management.')->prefix('management')->middleware(['checkForTenancy'])->group(function () {
    Route::get('/', ['uses' => 'Management\ManagementController@index', 'as' => 'index']);

    Route::get('tenants', ['uses' => 'Management\TenantController@index', 'as' => 'tenants.index']);
});

Route::name('office.')->prefix('office')->group(function () {
    Route::get('/', ['uses' => 'Office\OfficeController@index', 'as' => 'index']);

    Route::get('events', ['uses' => 'Office\EventController@index', 'as' => 'events.index']);
    Route::post('events', ['uses' => 'Office\EventController@store', 'as' => 'events.store']);
    Route::get('events/create', ['uses' => 'Office\EventController@create', 'as' => 'events.create']);
    Route::get('events/{slug}', ['uses' => 'Office\EventController@show', 'as' => 'events.show']);
    Route::get('events/{slug}/edit', ['uses' => 'Office\EventController@edit', 'as' => 'events.edit']);
    Route::put('events/{slug}/edit', ['uses' => 'Office\EventController@update', 'as' => 'events.update']);
    Route::delete('events/{slug}', ['uses' => 'Office\EventController@destroy', 'as' => 'events.destroy']);
});
