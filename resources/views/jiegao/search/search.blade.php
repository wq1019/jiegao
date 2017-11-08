@extends('jiegao.layouts.app')

@section('keywords'){!! $category->getKeywords() !!}@endsection
@section('description'){!! $category->getDescription() !!}@endsection
@section('title'){{ Breadcrumbs::pageTitle(' - ', 'category', $category) }}@endsection

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
                @php
                    $categoryRepository = app(App\Repositories\CategoryRepository::class);
                    $search = $categoryRepository->findByCateName('搜索');
                @endphp
                {{ Breadcrumbs::render('category', $search) }}
            </div>
            <ul class="post_list">
                @foreach($posts as $post)
                    @php
                        $pos = strrpos($post->title,$search);
                    if($pos==0 || $pos){
                        $pos=true;
                    }else{
                        $pos=false;
                    }
                    if($search != '' &&  $pos){
                        $post->title = str_ireplace($search,"<span style='color: red'>".$search."</span>",$post->title) ;
                    }
                    @endphp
                    <li>
                        <a href="{!! $post->getPresenter()->url() !!}">{{$post->title}}</a>
                        <span class="time">{!! $post->published_at !!}</span>
                    </li>
                @endforeach
            </ul>
            {!! $posts->fragment('list')->links() !!}
        </div>
    </div>
    <!-- 列表正文end -->
    @include('jiegao.layouts.particals.footer')
@endsection


