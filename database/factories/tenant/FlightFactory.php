<?php

use Carbon\Carbon;
use App\Models\Airport;
use App\Models\Tenants\Event;
use App\Models\Tenants\Pilot;
use Faker\Generator as Faker;
use App\Models\Tenants\Flight;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Flight::class, function (Faker $faker) {
    return [
        'event_id' => function () {
            return factory(Event::class)->create()->id;
        },
        'pilot_id' => function () {
            return factory(Pilot::class)->create()->id;
        },
        'callsign' => 'ABC123',
        'origin_airport_id' => function () {
            return factory(Airport::class)->create()->id;
        },
        'destination_airport_id' => function () {
            return factory(Airport::class)->create()->id;
        },
        'departure_time' => Carbon::now()->toTimeString(),
        'arrival_time' => Carbon::now()->addHours(2)->toTimeString(),
        'route' => 'ABCDE1 ABC ABC ABC ABCDE2',
        'aircraft_type_icao' => 'B734',
    ];
});

$factory->state(Flight::class, 'unbooked', function ($faker) {
    return [
        'pilot_id' => null,
    ];
});
