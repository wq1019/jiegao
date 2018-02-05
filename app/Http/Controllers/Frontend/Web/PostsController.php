<?php

namespace App\Http\Controllers\Frontend\Web;

use App\Events\PostHasBeenRead;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Services\Alert;
use Auth;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    /**
     * 正文.
     *
     * @param $slug
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug, Request $request)
    {
        /**
         * @var Post
         */
        $queryBuilder = Post::bySlug($slug);
        if (Auth::check()) {
            $post = $queryBuilder->where(
                function ($query) {
                    $query->publishOrDraft();
                }
            )->withTrashed()->firstOrFail();

            if (!$post->isPublish() || $post->trashed()) {
                // 管理员预览草稿或未发布的文章
                app(Alert::class)->setDanger('当前文章未发布，此页面只有管理员可见!');
            }
        } else {
            $post = $queryBuilder->publishPost()->firstOrFail();
        }

        event(new PostHasBeenRead($post, $request->getClientIp()));

        return view_first([$post->slug, $post->template, $post->category->content_template], 'content', ['post' => $post]);
    }

    /**
     * 搜索.
     */
    public function search(Request $request)
    {
        $keywords = $request->get('keywords');
        $posts = Post::withSimpleSearch($keywords, ['title', 'excerpt'])
            ->applyFilter(collect(['status' => Post::STATUS_PUBLISH]))
            ->with('user')
            ->paginate($this->perPage());

        return view(config('template.theme_namespace').'::search', ['posts' => $posts, 'keywords' => $keywords]);
    }
}
