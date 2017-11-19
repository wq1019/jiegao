@extends('jiegao.layouts.app')

@section('title'){{ Breadcrumbs::pageTitle(' - ', 'search', $keywords) }}@endsection
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
                {{ Breadcrumbs::view('jiegao.layouts.search_breadcrumbs', 'search', $keywords) }}
            </div>
            <ul class="post_list">
                @forelse($posts as $post)
                    <li>
                        <a href="{!! $post->getPresenter()->url() !!}">{!! sign_color($post->title, $keywords, config('tiny.keywords_color')) !!}</a>
                        <span class="time">{!! $post->published_at->format('Y年m月d日')!!}</span>
                    </li>
                @empty
                    <p class="no_data">暂无数据</p>
                @endforelse
            </ul>
            {!! $posts->fragment('list')->links() !!}
        </div>
    </div>
    <!-- 列表正文end -->
    @include('jiegao.layouts.particals.footer')
@endsection


