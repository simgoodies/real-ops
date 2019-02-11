<?php

Route::get('/', ['uses' => 'LandingPageController@index']);

Route::get('apply', ['uses' => 'ApplicationController@index', 'as' => 'applications.index']);

Route::get('airlines', ['uses' => 'AirlineController@index', 'as' => 'airlines.index']);
Route::post('airlines', 'AirlineController@store');

Route::name('management.')->prefix('management')->group(function () {
    Route::get('/', ['uses' => 'Management\ManagementController@index', 'as' => 'index']);

    Route::get('tenants', ['uses' => 'Management\TenantController@index', 'as' => 'tenants.index']);
});