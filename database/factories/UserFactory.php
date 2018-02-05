<?php

use Faker\Generator as Faker;

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password, $imagesPath = null;
    if (is_null($imagesPath)) {
        $imagesConfig = config('images');
        $storage = Storage::disk($imagesConfig['source_disk']);
        $imagesPath = $storage->path($imagesConfig['source_path_prefix']);
        $storage->exists($imagesPath) || $storage->makeDirectory($imagesConfig['source_path_prefix']);
    }

    return [
        'user_name'      => $faker->userName,
        'nick_name'      => $faker->name(),
        'email'          => $faker->unique()->safeEmail,
        'avatar'         => $faker->image($imagesPath, 480, 480, 'people', false),
        'password'       => $password ?: $password = bcrypt(config('tiny.default_user_password')),
        'locked_at'      => $faker->optional(0.1, null)->dateTime,
        'remember_token' => str_random(10),
        'created_at'     => \Carbon\Carbon::now(),
        'updated_at'     => \Carbon\Carbon::now(),
    ];
});
