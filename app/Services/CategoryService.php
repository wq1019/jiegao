<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    // todo cache
    public function visualOutput($type = null, $indentStr = '-')
    {
        $topicCategories = $this->getAllByType($type);
        $collect = collect([]);
        foreach ($topicCategories as $topicCategory) {
            $collect->push(['indent_str' => '', 'data' => $topicCategory]);
            foreach ($topicCategory->children as $child) {
                $collect->push(['indent_str' => $indentStr, 'data' => $child]);
            }
        }

        return $collect;
    }

    public function getAllByType($type)
    {
        $topicCategories = Category::topCategories()->ordered()->ancient()->get();
        $topicCategories->load(['children' => function ($query) use ($type) {
            $query->byType($type)->ordered()->ancient();
        }]);
        if (!is_null($type)) {
            $topicCategories = $topicCategories->filter(function ($category) use ($type) {
                return $category->type == $type || $category->children->isNotEmpty();
            });
        }

        return $topicCategories;
    }
}
