<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Services\VisitorService;
use Carbon\Carbon;

class HomeController extends ApiController
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function index(VisitorService $visitorService)
    {
        $posts = Post::byType(Category::TYPE_POST)->count();
        $users = User::count();
        $nowPVUV = $visitorService->getPVUVByDateWithoutCache(Carbon::today());
        $recentlyPVUV = $visitorService->getRecentlyPVUVFromCache();
        $yesterdayPVUV = $visitorService->getPVUVByDateFromCache(Carbon::yesterday());

        return compact('posts', 'users', 'nowPVUV', 'yesterdayPVUV', 'recentlyPVUV');
    }
}
