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

Route::get('office')->uses(OfficeController::class. '@index')->name('office.index');
Route::get('office/events/create')->uses(OfficeEventController::class . '@create')->name('office-events.create');
Route::get('office/events')->uses(OfficeEventController::class . '@index')->name('office-events.index');
Route::post('office/events')->uses(OfficeEventController::class . '@store')->name('office-events.store');
Route::get('office/events/{slug}')->uses(OfficeEventController::class . '@show')->name('office-events.show');
Route::post('office/events/{slug}/bookables/flight')->uses(BookableFlightController::class . '@store')->name('bookable-flights.store');
Route::post('office/events/{slug}/bookables')->uses(BookableController::class . '@store')->name('bookables.store');
Route::get('office/events/{slug}/bookables')->uses(BookableController::class . '@index')->name('bookables.index');
