<?php

namespace App\Widgets;

use App\Repositories\CategoryRepository;
use App\Services\Navigation;

class NavigationSidebar extends NavigationBar
{
    public function getData(array $params = [])
    {
        $navigation = app(Navigation::class);
        if (is_null($navigation->getActiveTopNav())) {
            $categoryRepository = app(CategoryRepository::class);
            $category = $categoryRepository->findByCateName('搜索');
            $navigation->setActiveNav($category);
        }
        return [
            'navigation' => $navigation,
            'allNav' => $navigation->getAllNav(),
            'activeTopNav' => $navigation->getActiveTopNav(),
        ];
    }
}
