<?php

Route::namespace('App\Http\Controllers\Tenants')->middleware('web')->name('tenants.')->group(function () {
    Route::get('/')->uses('PageController@landing')->name('landing');

    // Authentication Routes...
    Route::namespace('Auth')->name('auth.')->group(function () {
        // Login and Logout Routes...
        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login');
        Route::get('logout', 'LoginController@logout')->name('logout');

        // Password Reset Routes...
        Route::get(
            'password/reset',
            'ForgotPasswordController@showLinkRequestForm'
        )->name('password.request');
        Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'ResetPasswordController@reset');
    });

    // Office Routes...
    Route::name('office.')->prefix('office')->namespace('Office')->middleware(['auth', 'permission:access-office'])->group(function () {
        Route::get('/', ['uses' => 'OfficeController@index', 'as' => 'index']);
        
        Route::middleware('permission:access-staff-management')->group(function () {
            Route::get('staff-management')->uses('StaffManagementController@index')->name('staff-management.index');
            Route::post('staff-management/assign-role')->uses('StaffManagementRoleController@store')->name('staff-management-roles.store');
            Route::delete('staff-management/remove-role')->uses('StaffManagementRoleController@destroy')->name('staff-management-roles.destroy');
            Route::post('staff-management/create-user')->uses('StaffManagementUserController@store')->name('staff-management-users.store');
        });

        Route::get('events', ['uses' => 'EventController@index', 'as' => 'events.index']);
        Route::post('events', ['uses' => 'EventController@store', 'as' => 'events.store']);
        Route::get('events/create', ['uses' => 'EventController@create', 'as' => 'events.create']);
        Route::get('events/{slug}', ['uses' => 'EventController@show', 'as' => 'events.show']);
        Route::get('events/{slug}/edit', ['uses' => 'EventController@edit', 'as' => 'events.edit']);
        Route::put('events/{slug}/edit', ['uses' => 'EventController@update', 'as' => 'events.update']);
        Route::delete('events/{slug}', ['uses' => 'EventController@destroy', 'as' => 'events.destroy']);

        Route::name('events.flights.')->prefix('events/{slug}')->group(function () {
            Route::get('flights')->uses('FlightController@index')->name('index');
            Route::post('flights')->uses('FlightController@store')->name('store');
            Route::get('flights/{callsign}/edit')->uses('FlightController@edit')->name('edit');
            Route::patch('flights/{callsign}')->uses('FlightController@update')->name('update');
            Route::delete('flights/{callsign}')->uses('FlightController@destroy')->name('destroy');
        });
    });

    Route::get('events/{slug}')->uses('EventLandingPageController@show')->name('events.show');
    Route::get('events/{slug}/flights/{callsign}')->uses('FlightController@show')->name('events.flights.show');

    Route::post('events/{slug}/flights/{callsign}/book')->uses('Bookings\BookingRequestController@store')->name('events.flights.bookings.booking-request.store');
    Route::get('events/{slug}/flights/{callsign}/book/{vatsimId}')->uses('Bookings\BookingController@store')->name('events.flights.bookings.store');
    Route::post('events/{slug}/flights/{callsign}/cancel')->uses('Bookings\CancellationRequestController@store')->name('events.flights.bookings.cancellation-request.store');
    Route::get('events/{slug}/flights/{callsign}/cancel/{vatsimId}')->uses('Bookings\BookingController@destroy')->name('events.flights.bookings.destroy');
});
