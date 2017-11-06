@extends('jiegao.layouts.app')

{{--@section('keywords'){!! $category->getKeywords() !!}@endsection
@section('description'){!! $category->getDescription() !!}@endsection
@section('title'){{ Breadcrumbs::pageTitle(' - ', 'category', $category) }}@endsection--}}

@section('content')
    @widget('navigation_bar')
    <!-- 列表正文start -->
    <div class="list_top_bg"></div>
    <div class="list_container container">
        @widget('navigation_sidebar')
        <div class="main_list">
            <div class="header">
                {{--{{ Breadcrumbs::render('category', $category) }}--}}
            </div>
            <div class="content">
                <div class="title_container">
                    <h1>计算机学院：分党委组织师生收看党的十九大开幕式</h1>
                    <p class="info">
                        <span>2017-10-21 20:53:19</span>
                        <span>102 人阅读</span>
                        <span class="avatar">
                            上传：
                            <img lazy="" src="http://211.70.176.153/images/default_avatar.jpg">
                            <span class="uname">计算机学院</span>
                        </span>
                    </p>
                </div>
                <div class="text">
                    asdsadsad
                </div>
            </div>
        </div>
    </div>
    <!-- 列表正文end -->
    @include('jiegao.layouts.particals.footer')
@endsection

