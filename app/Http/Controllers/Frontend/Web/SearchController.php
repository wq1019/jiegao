<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/11/6
 * Time: 20:03
 */

namespace App\Http\Controllers\Frontend\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $posts = Post::withSimpleSearch($request->keywords)
            ->with('user')
            ->paginate($this->perPage())->appends($request->all());
        $categoryRepository = app(CategoryRepository::class);
        $category = $categoryRepository->findByCateName('搜索');
        return view_first([$category->cate_slug, $category->list_template], 'list', [
            'posts' => $posts,
            'category' => $category
        ]);
    }
}