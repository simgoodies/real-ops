<?php

Route::namespace('App\Http\Controllers\Tenant')->middleware('web')->name('tenants.')->group(function () {
    Route::get('/')->uses('PageController@landing')->name('landing');

    // Authentication Routes...
    Route::namespace('Auth')->name('auth.')->group(function () {
        // Login and Logout Routes...
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::get('logout', 'LoginController@logout')->name('logout');

        // Password Reset Routes...
        Route::get('password/reset',
            'ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset');
    });

    Route::name('office.')->prefix('office')->middleware(['auth', 'permission:access-office'])->group(function () {
        Route::get('/', ['uses' => 'Office\OfficeController@index', 'as' => 'index']);

        Route::get('events', ['uses' => 'Office\EventController@index', 'as' => 'events.index']);
        Route::post('events', ['uses' => 'Office\EventController@store', 'as' => 'events.store']);
        Route::get('events/create', ['uses' => 'Office\EventController@create', 'as' => 'events.create']);
        Route::get('events/{slug}', ['uses' => 'Office\EventController@show', 'as' => 'events.show']);
        Route::get('events/{slug}/edit', ['uses' => 'Office\EventController@edit', 'as' => 'events.edit']);
        Route::put('events/{slug}/edit', ['uses' => 'Office\EventController@update', 'as' => 'events.update']);
        Route::delete('events/{slug}', ['uses' => 'Office\EventController@destroy', 'as' => 'events.destroy']);

        Route::name('events.flights.')->prefix('events/{slug}')->middleware(['permission:access-flights'])->group(function () {
            Route::get('flights')->uses('Office\FlightController@index')->name('index');
            Route::post('flights')->uses('Office\FlightController@store')->name('store');
            Route::patch('flights/{callsign}')->uses('Office\FlightController@update')->name('update');
            Route::delete('flights/{callsign}')->uses('Office\FlightController@destroy')->name('destroy');
        });
    });
});
