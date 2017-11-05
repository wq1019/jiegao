@extends('jiegao.layouts.app')

@section('keywords'){!! $category->getKeywords() !!}@endsection
@section('description'){!! $category->getDescription() !!}@endsection
@section('title'){{ Breadcrumbs::pageTitle(' - ', 'category', $category) }}@endsection

@section('content')
    @include('jiegao.layouts.particals.navigation')
    <!-- 列表正文start -->
    <div class="list_top_bg"></div>
    <div class="list_container container">
        <div class="nav_menu">
            <ul>
                <li class="active">
                    <span class="pendant"></span>
                    <a href="#">招生就业</a>
                    <span class="arrow"></span>
                </li>
                <li>
                    <span class="pendant"></span>
                    <a href="#">招生计划</a>
                    <span class="arrow"></span>
                </li>
                <li>
                    <span class="pendant"></span>
                    <a href="#">就业工程</a>
                    <span class="arrow"></span>
                </li>
            </ul>
        </div>
        <div class="main_list">
            <div class="header">
                <ol class="breadcrumb">
                    {{ Breadcrumbs::render('category', $category) }}
                </ol>
            </div>
            <ul class="prod_list">
                @foreach($posts as $post)
                    <li>
                        <a href="{!! $post->getPresenter()->url() !!}">
                            <img src="{{image_url($post->cover)}}" alt="{{$post->title}}">
                            <h2>{{$post->title}}</h2>
                        </a>
                    </li>
                @endforeach
            </ul>
            {!! $posts->fragment('list')->links() !!}
        </div>
    </div>
    <!-- 列表正文end -->
    @include('jiegao.layouts.particals.footer')
@endsection

