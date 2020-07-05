<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'slug' => $faker->slug,
        'description' => $faker->paragraph,
        'start_date' => $faker->date(),
        'start_time' => $faker->time('H:i', '+4 hours'),
        'end_date' => $faker->date(),
        'end_time' => $faker->time('H:i', '+4 hours'),
    ];
});
