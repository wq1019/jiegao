@extends('jiegao.layouts.app')

@section('title'){!! $category->cate_name !!}@endsection

@section('content')
    @widget('navigation_bar')
    <!-- 列表正文start -->
    <div class="list_top_bg"></div>
    <div class="list_container container">
        @widget('navigation_sidebar')
        <div class="main_list">
            <div class="header">
                {!! Breadcrumbs::render('category', $category) !!}
            </div>
            <div class="content">
                <div class="title_container">
                    <h1>{!! $page->title !!}</h1>
                    <p class="info">
                        <span>{!! $page->published_at->format('Y年m月d日')!!}</span>
                        <span>{!! $page->views_count !!} 人阅读</span>
                        <span class="avatar">
                            上传：
                            <img lazy
                                 src="{!! image_url($page->user->avatar, 'avatar_xs', cdn('jiegao/images/default_avatar.jpg')) !!}">
                            <span class="uname">{!! isset($page->user->nick_name)?$page->user->nick_name:$page->user->user_name !!}</span>
                        </span>
                    </p>
                </div>
                <div class="text">
                    {!! $page->postContent->content !!}
                </div>
            </div>
        </div>
    </div>
    <!-- 列表正文end -->
    @include('jiegao.layouts.particals.footer')
@endsection

