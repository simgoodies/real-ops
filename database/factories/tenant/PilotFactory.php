<?php

use App\Models\Tenants\Pilot;
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

$factory->define(Pilot::class, function (Faker $faker) {
    return [
        'vatsim_id' => $faker->randomNumber(7),
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'email' => $faker->safeEmail,
    ];
});
