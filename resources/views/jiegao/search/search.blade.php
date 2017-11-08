@extends('jiegao.layouts.app')
@php
    $categoryRepository = app(App\Repositories\CategoryRepository::class);
    $search = $categoryRepository->findByCateName('搜索');
@endphp
@section('keywords'){!! $search->getKeywords() !!}@endsection
@section('description'){!! $search->getDescription() !!}@endsection
@section('title'){{ Breadcrumbs::pageTitle(' - ', 'category', $search) }}@endsection
@section('content')
    @widget('navigation_bar')
    <!-- 列表正文start -->
    <div class="list_top_bg"></div>
    <div class="list_container container">
        <div class="nav_menu">
            <ul>
                <li class="active">
                    <span class="pendant"></span>
                    <a>搜索</a>
                    <span class="arrow"></span>
                </li>
            </ul>
        </div>
        <div class="main_list">
            <div class="header">
                {{ Breadcrumbs::render('category', $search) }}
            </div>
            <ul class="post_list">
                @foreach($posts as $post)
                    <li>
                        <a href="{!! $post->getPresenter()->url() !!}">{!! sign_color($post->title, $keyword, '#FF7F24') !!}</a>
                        <span class="time">{!! $post->published_at->format('Y年m月d日')!!}</span>
                    </li>
                @endforeach
            </ul>
            {!! $posts->fragment('list')->links() !!}
        </div>
    </div>
    <!-- 列表正文end -->
    @include('jiegao.layouts.particals.footer')
@endsection


