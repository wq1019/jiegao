<?php

namespace App\Transformers\Backend;

use App\Models\Post;
use League\Fractal\TransformerAbstract;

class PageTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['post_content'];

    public function transform(Post $post)
    {
        return [
            'id'           => $post->id,
            'title'        => $post->title,
            'type'         => $post->type,
            'views_count'  => $post->views_count,
            'template'     => $post->template,
            'published_at' => $post->published_at->toDateTimeString(),
            'created_at'   => $post->created_at->toDateTimeString(),
            'updated_at'   => $post->updated_at->toDateTimeString(),
        ];
    }

    public function includePostContent(Post $post)
    {
        if (is_null($post)) {
            return $this->null();
        }
        $content = $post->postContent;
        if (is_null($content)) {
            return $this->null();
        } else {
            return $this->item($content, new PostContentTransformer());
        }
    }
}
