<?php

namespace App\Widgets;

class CorporateEnvironmentBanner extends Banner
{
    protected $config = [
        'type' => 'corporate_environment',
        'limit' => 10,
    ];

    public function getData(array $params = [])
    {
        return parent::getData($params);
    }
}
