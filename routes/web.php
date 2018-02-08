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
    Route::prefix('office')->group(function () {
        Route::get('/', ['uses' => 'OfficeController@index', 'as' => 'office.index']);

        Route::get('events', ['uses' => 'EventController@index', 'as' => 'events.index']);
        Route::post('events', ['uses' => 'EventController@store', 'as' => 'events.store']);
        Route::get('events/create', ['uses' => 'EventController@create', 'as' => 'events.create']);
        Route::get('events/{slug}', ['uses' => 'EventController@show', 'as' => 'events.show']);
    });
});
