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
            <div class="content content_prod">
                <div class="cover">
                    <img src="{{image_url($post->cover)}}" alt="">
                </div>
                <div class="info">
                    <h1>{{$post->title}}</h1>
                    @foreach($post->fields as $field)
                        <div class="item">
                            <span class="bold">{{$field['key']}}：</span>
                            <span>{{$field['value']}}</span>
                        </div>
                    @endforeach
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

