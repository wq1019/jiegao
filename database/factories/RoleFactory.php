<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Role::class, function (Faker $faker) {
    return [
        'name'           => $faker->name,
        'nick_name'      => $faker->name,
        'email'          => $faker->unique()->safeEmail,
        'avatar'         => $faker->imageUrl(100, 100),
        'is_locked'      => false,
        'remember_token' => str_random(10),
        'created_at'     => \Carbon\Carbon::now(),
        'updated_at'     => \Carbon\Carbon::now(),
    ];
});
