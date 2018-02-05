<?php

namespace App\Widgets;

use App\Services\Alert as AlertService;
use App\Support\Widget\AbstractWidget;

class Alert extends AbstractWidget
{
    protected $alertService;

    public function __construct($config)
    {
        parent::__construct($config);
        $this->alertService = app(AlertService::class);
    }

    public function getData(array $params = [])
    {
        return $this->alertService->getMessage();
    }

    public function render(array $params)
    {
        if ($this->alertService->hasMessage()) {
            return parent::render($params);
        } else {
            return '';
        }
    }
}
