<?php

namespace App\Http\Controllers\Frontend\Web;

use App\Events\VisitedPostList;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show($slug, Request $request, CategoryRepository $categoryRepository)
    {
        /**
         * @var Category
         */
        $category = $categoryRepository->findBySlug($slug);
        event(new VisitedPostList($category));

        if ($category->isPostList()) {
            return $this->showList($category, $request);
        } else {
            return $this->showPage($category);
        }
    }

    protected function showList(Category $category, Request $request)
    {
        $posts = $category->postListWithOrder($request->get('order'))->with('user')->paginate($this->perPage());
        $posts->appends($request->all());

        return view_first([$category->cate_slug, $category->list_template], 'list', [
            'posts'    => $posts,
            'category' => $category,
        ]);
    }

    protected function showPage(Category $category)
    {
        $page = $category->getPage();
        if (is_null($page)) {
            // todo
            abort(404, '该单页还没有初始化');
        }

        return view_first([$category->cate_slug, $category->page_template], 'page', [
            'category' => $category,
            'page'     => $page,
        ]);
    }
}
