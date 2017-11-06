<?php


namespace App\Widgets;


use App\Models\Link as LinkModel;
use App\Services\CustomOrder;
use App\Support\Widget\AbstractWidget;

class Link extends AbstractWidget
{

    protected $config = [
        'type' => 'default',
        'limit' => 10,
    ];

    public function getData(array $params = [])
    {
        return [
            'links' => app(CustomOrder::class)
                ->order(LinkModel::byType($this->config['type'])->limit($this->config['limit'])->ancient()->get()),
        ];
    }

}
