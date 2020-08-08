<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BookableFlight;
use App\Models\Event;
use Faker\Generator as Faker;

$factory->define(BookableFlight::class, function (Faker $faker) {
    return [
        'event_id' => factory(Event::class)->create()->id,
        'begin_date' => $faker->date(),
        'begin_time' => $faker->time(),
        'end_date' => $faker->date(),
        'end_time' => $faker->time(),
        'data' => [
            'callsign' => $faker->randomElement(['FOO123', 'BAR123', 'BAZ123']),
            'origin_airport_icao' => $faker->randomElement(['FOO1', 'BAR1', 'BAZ1']),
            'destination_airport_icao' => $faker->randomElement(['FOO2', 'BAR2', 'BAZ2']),
        ],
    ];
});
