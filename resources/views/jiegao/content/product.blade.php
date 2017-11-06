@extends('jiegao.layouts.app')

@section('keywords'){!! $post->getKeywords() !!}@endsection
@section('description'){!! $post->getDescription() !!}@endsection
@section('title'){!! $post->title !!}@endsection

@section('content')
    @widget('navigation_bar')
    <!-- 列表正文start -->
    <div class="list_top_bg"></div>
    <div class="list_container container">
        @widget('navigation_sidebar')
        <div class="main_list">
            <div class="header">
                {!! Breadcrumbs::render('post', $post) !!}
            </div>
            <div class="content content_prod">
                <div class="cover">
                    <img src="{{image_url($post->cover)}}" alt="">
                </div>
                <div class="info">
                    <h1>{{$post->title}}</h1>
                    <div class="item">
                        <span class="bold">品牌：</span>
                        <span>捷高</span>
                    </div>
                    <div class="item">
                        <span class="bold">型号：</span>
                        <span>HLH-102A</span>
                    </div>
                    <div class="item">
                        <span class="bold">描述：</span>
                        <span>这是一款装在光纤熔接机上的不锈钢加热片，功能：加热，热熔。阻值可根据客户要求定做，目前有5R，7.7R的阻值两款。</span>
                    </div>
                </div>
                <div class="describe">
                    <h4>
                        产品介绍
                        <div class="line"></div>
                    </h4>
                    <div class="text">
                        {!! $post->postContent->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 列表正文end -->
    @include('jiegao.layouts.particals.footer')
@endsection

