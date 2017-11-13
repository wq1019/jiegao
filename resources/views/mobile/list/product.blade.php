@extends('mobile.layouts.default')

@section('title'){!! $category->cate_name !!}@endsection

@section('content')
    <!-- 题图 -->
    <div class="page_bg">
        <h2>产品中心</h2>
    </div>
    <!-- 产品中心 -->
    <div class="product">
        <ul class="product_list">
            @forelse($posts as $post)
                <li>
                    <div class="img_info">
                        <a href="{!! $post->getPresenter()->url() !!}">
                            <img src="{!! image_url($post->cover, 'product_cover_index') !!}">
                            <p class="title">{!! $post->title !!}</p>
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
@endsection