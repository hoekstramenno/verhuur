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

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Carbon\Carbon;

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Date::class, function (Faker\Generator $faker) {

    return [
        'date_from' => Carbon::parse('+2 weeks'),
        'date_to' => Carbon::parse('+2 weeks, +1 day'),
        'price' => 520,
        'status' => App\Date::STATUS_AVAILABLE
    ];
});

$factory->state(App\Date::class, 'published', function ($faker) {
    return [
        'published_at' => Carbon::parse('-1 week')
    ];
});

$factory->state(App\Date::class, 'unpublished', function ($faker) {
    return [
        'published_at' => null
    ];
});

$factory->define(App\Option::class, function (Faker\Generator $faker) {
    return [
        'date_id' => 1,
        'email' => $faker->safeEmail,
        'pax' => '10',
        'amount' => '5000'
    ];
});

$factory->define(App\Booking::class, function (Faker\Generator $faker) {
    return [];
});