<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
    ];
});

$factory->define(App\Api\Classes\Classes::class, function (Faker\Generator $faker) {
    $startDate = date('Y-m-d');
    $endDate = date('Y-m-d', strtotime($startDate.' +1 day'));

    return [
        'name' => $faker->name,
        'start_date' => $startDate,
        'end_date' => $endDate,
        'capacity' => $faker->randomNumber(1),
    ];
});

$factory->define(App\Api\Booking\Booking::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'date' => date('Y-m-d'),
    ];
});
