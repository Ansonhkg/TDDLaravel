<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

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

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Concert::class, function(Faker $faker){
    return [
        'title' => 'Example band',
        'subtitle' => 'with The Fake Opener',
        'date' => Carbon::parse('+2 weeks'),
        'ticket_price' => 2000,
        'venue' => 'The Example Theatre',
        'venue_address' => '123 Example Lane',
        'city' => 'Fakeville',
        'post_code' => 'rg48ew',
        'addtional_information' => 'Some Sample Addtion Information.',
    ];
});

$factory->state(App\Concert::class, 'published', function($faker){
    return [
        'published_at' => Carbon::parse('-1 week'),
    ];
});

$factory->state(App\Concert::class, 'unpublished', function($faker){
    return [
        'published_at' => null,
    ];
});
