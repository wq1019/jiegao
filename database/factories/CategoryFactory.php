<?php

use App\Models\Category;
use Faker\Generator as Faker;

$factory->define(App\Models\Category::class, function (Faker $faker) {
    static $imagesPath = null;
    if (is_null($imagesPath)) {
        $imagesConfig = config('images');
        $storage = Storage::disk($imagesConfig['source_disk']);
        $imagesPath = $storage->path($imagesConfig['source_path_prefix']);
        $storage->exists($imagesPath) || $storage->makeDirectory($imagesConfig['source_path_prefix']);
    }

    return [
        'type'      => $faker->randomElement([Category::TYPE_POST, Category::TYPE_PAGE, Category::TYPE_LINK]),
        'parent_id' => 0,
        'cate_name' => $faker->unique()->word,
        // todo 根据 type 决定是否生成 image and windows image is null
        'image'       => $faker->image($imagesPath, 640, 480, null, false),
        'description' => $faker->text(190),
        'url'         => function (array $category) use ($faker) {
            switch ($category['type']) {
                case Category::TYPE_LINK:
                    return $faker->url;
                    break;
                default:
                    return;
                    break;
            }
        },
        'cate_slug' => $faker->unique()->slug,

        'is_target_blank' => function (array $category) use ($faker) {
            switch ($category['type']) {
                case Category::TYPE_LINK:
                    return $faker->boolean;
                    break;
                default:
                    return true;
                    break;
            }
        },
        'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now(),
        'is_nav'     => $faker->boolean,
        'order'      => $faker->randomDigitNotNull,
    ];
});
