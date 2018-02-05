<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\ApiController;

class PermissionsController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
    }
}
