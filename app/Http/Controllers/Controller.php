<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * 分页时每页显示多少数据.
     *
     * @return int
     */
    public function perPage($default = null)
    {
        $maxPerPage = config('tiny.max_per_page');
        if (method_exists($this, 'defaultPerPage')) {
            $perPage = (request('per_page') ?: $default) ?: $this->defaultPerPage();
        }

        return (int) ($perPage < $maxPerPage ? $perPage : $maxPerPage);
    }

    public function defaultPerPage()
    {
        return config('tiny.default_per_page');
    }
}
