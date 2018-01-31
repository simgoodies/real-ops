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

Route::post('events', 'EventController@store');
Route::get('events/{slug}', ['uses' => 'EventController@show', 'as' => 'events.show']);