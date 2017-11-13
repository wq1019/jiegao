@extends('mobile.layouts.default')

@section('title'){!! $post->title !!}@endsection

@section('content')
<!-- 正文 -->
<div class="content_main">
    <h2 class="title">{!! $post->title !!}</h2>
    <div class="info">
        <span class="author">{!! isset($post->user->nick_name)?$post->user->nick_name:$post->user->user_name !!}</span>
        <span class="bull">•</span>
        <span class="time">{!! $post->published_at !!}</span>
        <span>浏览量 {!! $post->views_count !!}</span>
    </div>
    <div class="content">{!! $post->postContent->content !!}</div>
</div>
@endsection
