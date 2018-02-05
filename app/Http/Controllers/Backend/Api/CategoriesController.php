<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Backend\CategoryCreateRequest;
use App\Http\Requests\Backend\CategoryUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use App\Repositories\CategoryRepository;
use App\Repositories\PageRepository;
use App\Services\CategoryService;
use App\Transformers\Backend\CategoryTransformer;
use App\Transformers\Backend\PageTransformer;
use App\Transformers\Backend\VisualCategoryTransformer;
use Illuminate\Http\Request;

class CategoriesController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Category $category)
    {
        return $this->response()->item($category, new CategoryTransformer());
    }

    public function store(CategoryCreateRequest $request, CategoryRepository $categoryRepository)
    {
        $categoryRepository->create($request->validated());

        return $this->response()->noContent();
    }

    public function update(Category $category, CategoryUpdateRequest $request, CategoryRepository $categoryRepository)
    {
        $categoryRepository->update($request->validated(), $category);

        return $this->response()->noContent();
    }

    public function index(Request $request, CategoryService $categoryService)
    {
        $topicCategories = $categoryService->getAllByType($request->get('type', null));

        return $this->response()->collection($topicCategories, (new CategoryTransformer())->setDefaultIncludes(['children']))->disableEagerLoading();
    }

    public function visualOutput(Request $request, CategoryService $categoryService)
    {
        $categories = $categoryService->visualOutput($request->get('type'), '　∟　');

        return $this->response()->collection($categories, new VisualCategoryTransformer());
    }

    public function destroy(Category $category)
    {
        $category->children()->delete();
        $category->delete();

        return $this->response()->noContent();
    }

    public function page(Category $category)
    {
        $this->needPage($category);
        $page = $category->getPage();
        if (is_null($page)) {
            return $this->response()->null();
        } else {
            return $this->response()->item($page, new PageTransformer())->addMeta('cate_name', $category->cate_name);
        }
    }

    private function updatePage(Post $page, Request $request, PageRepository $pageRepository)
    {
        // 更新单页
        $data = $this->validate(
            $request, [
                'title'          => ['nullable', 'string', 'between:1,100'],
                'content'        => ['nullable', 'string'],
                'attachment_ids' => ['nullable', 'array'],
            ]
        );

        return $pageRepository->update($data, $page);
    }

    private function storePage(Category $category, Request $request, PageRepository $pageRepository)
    {
        $data = $this->validate(
            $request, [
                'title'          => ['required', 'string', 'between:1,100'],
                'content'        => ['required', 'string'],
                'attachment_ids' => ['nullable', 'array'],
            ]
        );
        $data['category_id'] = $category->id;

        return $pageRepository->create($data);
    }

    public function savePage(Category $category, Request $request, PageRepository $pageRepository)
    {
        $this->needPage($category);
        $page = $category->getPage();
        if (is_null($page)) {
            $this->storePage($category, $request, $pageRepository);
        } else {
            $this->updatePage($page, $request, $pageRepository);
        }

        return $this->response()->noContent();
    }

    private function needPage(Category $category)
    {
        if (!$category->isPage()) {
            // todo 本地化
            return $this->response()->errorNotFound('该栏目不是单网页');
        }

        return true;
    }
}
