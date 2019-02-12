<?php

Route::get('/', ['uses' => 'PageController@landing']);
Route::get('contact', ['uses' => 'PageController@contact', 'as' => 'core.pages.contact']);
Route::get('apply', ['uses' => 'PageController@application', 'as' => 'core.pages.application']);

Route::get('airlines', ['uses' => 'AirlineController@index', 'as' => 'airlines.index']);
Route::post('airlines', 'AirlineController@store');

Route::name('management.')->prefix('management')->group(function () {
    Route::get('/', ['uses' => 'Management\ManagementController@index', 'as' => 'index']);

    Route::get('tenants', ['uses' => 'Management\TenantController@index', 'as' => 'tenants.index']);
});
