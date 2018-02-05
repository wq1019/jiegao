<?php

namespace App\Events;

use App\Models\Category;

class VisitedPostList
{
    public $category;

    /**
     * VisitedPostList constructor.
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
}
