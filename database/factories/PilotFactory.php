<?php
/**
 * @author Roël Gonzalez
 * @license MIT
 */

use Faker\Generator as Faker;
use App\Models\Pilot;

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
        'tenant_id' => 1,
        'vatsim_number' => $faker->randomNumber(7),
        'first_name' => $faker->firstName(),
        'last_name' => $faker->lastName(),
        'email' => $faker->safeEmail
    ];
});
