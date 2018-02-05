<?php

use App\Models\Category;
use App\Models\Post;
use Faker\Generator as Faker;

// todo 正文模版填充

$factory->define(Post::class, function (Faker $faker) {
    static $imagesPath = null, $categories = null;

    if (is_null($imagesPath)) {
        $imagesConfig = config('images');
        $storage = Storage::disk($imagesConfig['source_disk']);
        $imagesPath = $storage->path($imagesConfig['source_path_prefix']);
        $storage->exists($imagesPath) || $storage->makeDirectory($imagesConfig['source_path_prefix']);
    }

    if (is_null($categories)) {
        $categories = Category::all('id', 'type')->keyBy('id')->all();
    }
    $category = $faker->randomElement($categories);
    $data = [
        'title'        => $faker->sentence,
        'slug'         => $faker->unique()->slug,
        'excerpt'      => $faker->paragraph,
        'cover'        => $faker->image($imagesPath, 1100, 510, null, false),
        'category_id'  => $category->id,
        'status'       => $faker->optional(0.4, Post::STATUS_PUBLISH)->randomElement([Post::STATUS_PUBLISH, Post::STATUS_DRAFT]),
        'type'         => $faker->optional(0.2, Category::TYPE_POST)->randomElement([Category::TYPE_POST, Category::TYPE_PAGE]),
        'views_count'  => random_int(0, 10000),
        'top'          => $faker->optional(0.2)->dateTime(),
        'order'        => random_int(-1000, 1000),
        'published_at' => \Carbon\Carbon::now(),
        'created_at'   => \Carbon\Carbon::now(),
        'updated_at'   => \Carbon\Carbon::now(),
    ];
    if ($category->type == Category::TYPE_PAGE) {
        unset($categories[$category->id]);
    }

    return $data;
});
