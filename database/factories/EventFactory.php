<?php

use Carbon\Carbon;
use App\Models\Tenants\Event;
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

$factory->define(Event::class, function (Faker $faker) {
    return [
        'title' => 'Hakuna Matata Real Ops 2018',
        'description' => 'Super awesome description as to why Hakuna Matata Real Ops 2018 will be the bomb!',
        'start_time' => Carbon::now()->addDays(3)->format('Y-m-d H:i:s'),
        'end_time' => Carbon::now()->addDays(3)->addHours(4)->format('Y-m-d H:i:s'),
        'start_date' => Carbon::now()->addDays(3)->format('Y-m-d H:i:s'),
        'end_date' => Carbon::now()->addDays(3)->addHours(4)->format('Y-m-d H:i:s')
    ];
});
