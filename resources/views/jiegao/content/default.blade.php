@extends('jiegao.layouts.app')

@section('keywords'){!! $post->getKeywords() !!}@endsection
@section('description'){!! $post->getDescription() !!}@endsection
@section('title'){!! $post->title !!}@endsection

@section('content')
    @widget('navigation_bar')
    <!-- 列表正文start -->
    <div class="list_top_bg"></div>
    <div class="list_container container">
        @widget('navigation_bar',['view'=>'navigation_sidebar'])
        <div class="main_list">
            <div class="header">
                {!! Breadcrumbs::render('post', $post) !!}
            </div>
            <div class="content">
                <div class="title_container">
                    <h1>{!! $post->title !!}</h1>
                    <p class="info">
                        <span>{!! $post->published_at->format('Y年m月d日')!!}</span>
                        <span>{!! $post->views_count !!} 人阅读</span>
                        <span class="avatar">
                            上传：
                            <img lazy src="{!! image_url($post->user->avatar, 'avatar_xs', cdn('jiegao/images/default_avatar.jpg')) !!}">
                            <span class="uname">{!! isset($post->user->nick_name)?$post->user->nick_name:$post->user->user_name !!}</span>
                        </span>
                    </p>
                </div>
                <div class="text">
                    {!! $post->postContent->content !!}
                </div>
            </div>
        </div>
    </div>
    <!-- 列表正文end -->
    @include('jiegao.layouts.particals.footer')
@endsection

