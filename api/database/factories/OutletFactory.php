<?php

use Faker\Generator as Faker;

$factory->define(App\Outlet::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\en_US\Address($faker));
    return [
        'name' => $faker->unique()->city,
        'is_active' => $faker->boolean(),
        'user_id' => 1,
    ];
});
