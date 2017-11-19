@extends('jiegao.layouts.app')

@section('title'){!! $category->cate_name !!}@endsection

@section('content')
    @widget('navigation_bar')
    <!-- 列表正文start -->
    <div class="list_top_bg"></div>
    <div class="list_container container">
        @widget('navigation_bar',['view'=>'navigation_sidebar'])
        <div class="main_list">
            <div class="header">
                {!! Breadcrumbs::render('category', $category) !!}
            </div>
            <div class="content">
                <div class="title_container page">
                    <h1>{!! $page->title !!}</h1>
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

