<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Post;
use App\Services\PostService;
use Auth;
use Carbon\Carbon;
use Naux\AutoCorrect;

class PageRepository extends BaseRepository
{
    /**
     * Specify Model class name.
     *
     * @return string
     */
    public function model()
    {
        return Post::class;
    }

    public function filterData(array &$data)
    {
        if (isset($data['title'])) {
            $data['title'] = e((new AutoCorrect())->convert($data['title']));
        }
        if (isset($data['content'])) {
            $data['content'] = clean($data['content']);
        }

        return $data;
    }

    public function preCreate(array &$data)
    {
        $this->filterData($data);
        $data['published_at'] = Carbon::now();
        $data['user_id'] = Auth::id();
        $data['slug'] = $this->model->generateSlug($data['title']);
        $data['type'] = Category::TYPE_PAGE;
        $data['status'] = Post::STATUS_DRAFT;
        $data['excerpt'] = app(PostService::class)->makeExcerpt($data['content']);

        return $data;
    }

    public function created(&$data, $post)
    {
        $this->updateOrCreatePostContent($post, $data);
    }

    public function preUpdate(array &$data, $post)
    {
        $data = $this->filterData($data);
        if (isset($data['title']) && $post->title != $data['title']) {
            $data['slug'] = $this->model->generateSlug($data['title']);
        }
        if (!isset($data['excerpt']) && isset($data['content'])) {
            $data['excerpt'] = app(PostService::class)->makeExcerpt($data['content']);
        }

        return $data;
    }

    public function updated(&$data, $post)
    {
        $this->updateOrCreatePostContent($post, $data);
    }

    /**
     * 更新或创建文章正文.
     *
     * @param Post $post
     * @param $content
     */
    private function updateOrCreatePostContent(Post $post, &$data)
    {
        if (isset($data['content'])) {
            $post->postContent()->updateOrCreate(
                [], [
                    'content' => $data['content'],
                ]
            );
        }
    }
}
