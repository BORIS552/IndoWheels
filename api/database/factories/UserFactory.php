<?php

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

$factory->define(App\User::class, function (Faker $faker) {

    $faker->addProvider(new \Faker\Provider\Internet($faker));
    $faker->addProvider(new \Faker\Provider\en_US\PhoneNumber($faker));
    $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
    $faker->addProvider(new \Faker\Provider\Uuid($faker));
    $phone = $faker->unique()->e164PhoneNumber;

    return [
        'type' => 'user',
        'name' => $faker->name,
        'phone' => $phone,
        'api_token' => Hash::make($phone),
    ];

});
