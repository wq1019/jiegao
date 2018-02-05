<?php

namespace App\Transformers\Backend;

use League\Fractal\TransformerAbstract;

class VisualCategoryTransformer extends TransformerAbstract
{
    public function transform($category)
    {
        $indentStr = $category['indent_str'];
        $category = $category['data'];

        return [
            'id'               => $category->id,
            'type'             => $category->type,
            'image'            => $category->image,
            'image_url'        => image_url($category->image),
            'parent_id'        => $category->parent_id,
            'cate_name'        => $category->cate_name,
            'description'      => $category->description,
            'url'              => $category->url,
            'slug'             => $category->cate_slug,
            'is_nav'           => $category->is_nav,
            'order'            => $category->order,
            'page_template'    => $category->page_template,
            'list_template'    => $category->list_template,
            'content_template' => $category->content_template,
            // 'setting' => $category->setting,
            'indent_str' => $indentStr,
            'created_at' => $category->created_at->toDateTimeString(),
            'updated_at' => $category->updated_at->toDateTimeString(),
        ];
    }
}
