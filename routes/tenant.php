<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Stancl\Tenancy\Middleware\ScopeSessions;

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



Route::middleware([
    'web',
    PreventAccessFromCentralDomains::class,
    InitializeTenancyBySubdomain::class,
])->group(function () {
    Route::get('login-user/{token}')->uses(LoginUserController::class)->name('login-user');

    Route::get('events/{event}')->uses(EventController::class . '@show')->name('events.show');
    Route::get('booker/{booker}/booking/{bookable}/confirm')->uses(BookableController::class . '@confirm')->name('bookings.store');
});

Route::middleware([
    'web',
    'auth',
    'verified',
    ScopeSessions::class,
    PreventAccessFromCentralDomains::class,
    InitializeTenancyBySubdomain::class,
])->group(function () {
    // Authentication Routes
    Route::post('tenant-logout', 'Auth\LoginController@logout')->name('tenant-logout');

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('templates/flight-template')->uses(TemplateDownloadController::class . '@flightTemplate')->name('download-flight-template');

    Route::get('office')->uses(OfficeController::class. '@index')->name('office.index');

    // Office Staff
    Route::get('office/staff')->uses(StaffController::class .  '@index')->name('staff.index');
    Route::post('office/staff/invite')->uses(StaffController::class . '@invite')->name('staff-invite.store');

    // Office Events
    Route::get('office/events/create')->uses(OfficeEventController::class . '@create')->name('office-events.create');
    Route::get('office/events')->uses(OfficeEventController::class . '@index')->name('office-events.index');
    Route::post('office/events')->uses(OfficeEventController::class . '@store')->name('office-events.store');
    Route::get('office/events/{event}')->uses(OfficeEventController::class . '@show')->name('office-events.show');
    Route::delete('office/events/{event}')->uses(OfficeEventController::class . '@destroy')->name('office-events.destroy');
});
