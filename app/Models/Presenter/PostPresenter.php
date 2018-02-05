<?php

namespace App\Models\Presenter;

use App\Support\Presenter\Presenter;

class PostPresenter extends Presenter
{
    public function suitedTitle($length = 88)
    {
        return str_limit($this->title, $length);
    }

    public function url()
    {
        return route('frontend.web.post.show', $this->slug);
    }
}
