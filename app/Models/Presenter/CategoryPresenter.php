<?php

namespace App\Models\Presenter;

use App\Support\Presenter\Presenter;

class CategoryPresenter extends Presenter
{
    public function linkAttribute()
    {
        if ($this->isExtLink()) {
            return ' href="'.$this->url.'"'.($this->is_target_blank ? ' target="_blank"' : '');
        } else {
            return ' href="'.route('frontend.web.category.show', $this->cate_slug).'"';
        }
    }
}
