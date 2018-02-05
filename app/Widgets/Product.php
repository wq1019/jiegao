<?php

namespace App\Widgets;

use App\Repositories\CategoryRepository;
use App\Support\Widget\AbstractWidget;

class Product extends AbstractWidget
{
    protected $config = [
        'limit' => 6,
    ];

    public function getData(array $params = [])
    {
        $categoryRepository = app(CategoryRepository::class);
        $products = $categoryRepository->findByCateName('产品中心');

        return [
            'category' => $products,
            'posts'    => $products->postListWithOrder('default')->limit($this->config['limit'])->get(),
        ];
    }
}
