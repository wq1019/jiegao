<?php

use App\Models\PostContent;
use Faker\Generator as Faker;

$factory->define(PostContent::class, function (Faker $faker) {
    return [
        'content' => $faker->realText(5000),
    ];
});
