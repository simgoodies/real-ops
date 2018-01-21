<?php
/**
 * @author Roël Gonzalez
 * @license MIT
 */

use App\Models\Airport;
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

$factory->define(Airport::class, function (Faker $faker) {
    return [
        'iata_code' => 'ABC',
        'icao_code' => 'ABCD',
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'city' => $faker->city,
        'state' => $faker->city,
        'country' => $faker->country,
        'elevation' => $faker->numberBetween(0, 3000)
    ];
});
