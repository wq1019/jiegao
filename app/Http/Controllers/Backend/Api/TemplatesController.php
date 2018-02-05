<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\ApiController;
use App\Services\TemplateService;
use Illuminate\Http\Request;

class TemplatesController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function templates(Request $request)
    {
        $templates = app(TemplateService::class)->getTemplates($request->get('template_type'));
        if ($templates) {
            return $this->response()->setContent($templates);
        } else {
            return $this->response()->null();
        }
    }
}
