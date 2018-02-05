<?php

namespace App\Widgets;

use App\Models\Banner as BannerModel;
use App\Services\CustomOrder;
use App\Support\Widget\AbstractWidget;

class Banner extends AbstractWidget
{
    protected $config = [
        'type'  => 'default',
        'limit' => 10,
        'view'  => 'banner', // default view
    ];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->setViewName('theme::widgets.'.$this->config['view']);
    }

    public function getData(array $params = [])
    {
        return [
            'banners' => app(CustomOrder::class)
                ->order(BannerModel::byType($this->config['type'])->limit($this->config['limit'])->ancient()->get()),
        ];
    }
}
