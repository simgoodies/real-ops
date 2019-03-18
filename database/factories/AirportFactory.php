<?php

use App\Models\Airport;
use Illuminate\Support\Str;
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
        'icao' => Str::upper(Str::random(4)),
        'iata' => Str::upper(Str::random(3)),
        'name' => 'Luis Munoz Marin International Airport',
        'elevation_feet' => '9',
        'continent' => 'NA',
        'iso_country' => 'PR',
        'iso_region' => 'PR-U-A',
        'municipality' => 'San Juan',
        'coordinates' => '-66.0018005371, 18.4393997192',
    ];
});
