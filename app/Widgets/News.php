<?php

namespace App\Widgets;

use App\Repositories\CategoryRepository;
use App\Support\Widget\AbstractWidget;

class News extends AbstractWidget
{

    protected $config = [
        'limit' => 4
    ];
    public function getData(array $params = [])
    {
        $categoryRepository = app(CategoryRepository::class);
        $products = $categoryRepository->findByCateName('新闻资讯');
        //$category = Category::byCateSlug('xin-wen-zhong-xin')->firstOrFail();
        return [
            'category' => $products,
            'posts' => $products->postListWithOrder('default')->limit($this->config['limit'])->get()
        ];
    }

}
