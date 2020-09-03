<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\BookableTimeSlot;
use App\Models\Event;
use Faker\Generator as Faker;

$factory->define(BookableTimeSlot::class, function (Faker $faker) {
    return [
        'event_id' => factory(Event::class)->create()->id,
        'begin_date' => $faker->date(),
        'begin_time' => $faker->time(),
        'end_date' => $faker->date(),
        'end_time' => $faker->time(),
        'data' => [
            'direction' => BookableTimeSlot::DIRECTION_ANY,
        ],
    ];
});
