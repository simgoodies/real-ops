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

Route::get('apply', ['uses' => 'ApplicationController@create']);
Route::post('apply', ['uses' => 'ApplicationController@store', 'as' => 'applications.store']);
Route::get('successfully-applied', ['uses' => 'AppliedController@index', 'as' => 'applied.index']);

Route::get('airlines', ['uses' => 'AirlineController@index', 'as' => 'airlines.index']);
Route::post('airlines', 'AirlineController@store');

Route::group(['middleware' => ['tenancycheck']], function () {
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
});
