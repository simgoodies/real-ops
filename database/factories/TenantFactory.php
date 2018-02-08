<?php

use Carbon\Carbon;
use App\Models\Tenant;
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

$factory->define(Tenant::class, function (Faker $faker) {
    return [
        'id' => 1,
        'fir_name' => 'Hakuna Matata FIR',
        'icao' => 'HKMT',
        'active' => 1
    ];
});