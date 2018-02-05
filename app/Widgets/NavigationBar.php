<?php

namespace App\Widgets;

use App\Services\Navigation;
use App\Support\Widget\AbstractWidget;

class NavigationBar extends AbstractWidget
{
    protected $config = [
        'view' => 'navigation_bar', // default view
    ];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->setViewName('theme::widgets.'.$this->config['view']);
    }

    public function getData(array $params = [])
    {
        $navigation = app(Navigation::class);

        return [
            'navigation'   => $navigation,
            'allNav'       => $navigation->getAllNav(),
            'activeTopNav' => $navigation->getActiveTopNav(),
        ];
    }
}
