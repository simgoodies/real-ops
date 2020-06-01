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

Route::get('office/events/create')->uses(OfficeEventController::class . '@create')->name('office-event.create');
Route::post('office/events')->uses(OfficeEventController::class . '@store')->name('office-event.store');
Route::get('office/events/{slug}')->uses(OfficeEventController::class . '@show')->name('office-event.show');
Route::post('office/events/{slug}/bookables/flight')->uses(BookableFlightController::class . '@store')->name('bookable-flight.store');
Route::post('office/events/{slug}/bookables')->uses(BookableController::class . '@store')->name('bookable.index');
