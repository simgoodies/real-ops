<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Booker;
use Faker\Generator as Faker;

$factory->define(Booker::class, function (Faker $faker) {
    return [
        'email' => $faker->safeEmail,
    ];
});
