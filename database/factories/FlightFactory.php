<?php
/**
 * @author Roël Gonzalez
 * @license MIT
 */

use App\Models\Flight;
use Carbon\Carbon;
use Faker\Generator as Faker;

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
        'tenant_id' => 1,
        'airline_id' => 1,
        'event_id' => 1,
        'pilot_id' => function () {
            return factory('App\Models\Pilot')->create()->id;
        },
        'origin_airport_id' => function () {
            return factory('App\Models\Airport')->create()->id;
        },
        'destination_airport_id' => function () {
            return factory('App\Models\Airport')->create()->id;
        },
        'number' => 'ABC123',
        'departure_time' => Carbon::now()->toTimeString(),
        'arrival_time' => Carbon::parse('+1 hour')->toTimeString()
    ];
});

$factory->state(Flight::class, 'unbooked', function ($faker) {
    return [
        'pilot_id' => null,
    ];
});
