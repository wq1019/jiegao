<?php

// Index
Breadcrumbs::register('index', function ($breadcrumbs) {
    $breadcrumbs->push('首页', route('frontend.web.index'));
});

// 搜索
Breadcrumbs::register('search', function ($breadcrumbs, $keywords) {
    $breadcrumbs->push('首页', route('frontend.web.index'));
    $breadcrumbs->push("\"$keywords\"".' 的搜索结果');
});
Breadcrumbs::register('category', function ($breadcrumbs, $category) {
    if ($category->isTopCategory()) {
        // 是顶级分类
        $breadcrumbs->parent('index');
    } else {
        $breadcrumbs->parent('category', $category->parent);
    }

    $breadcrumbs->push($category->cate_name, route('frontend.web.category.show', $category->cate_slug));
});

Breadcrumbs::register('post', function ($breadcrumbs, $post) {
    $breadcrumbs->parent('category', $post->category);
    $breadcrumbs->push($post->title, route('frontend.web.post.show', $post->slug));
});
