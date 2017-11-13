 @extends('mobile.layouts.default')

 @section('title'){!! $category->cate_name !!}@endsection

 @section('content')
     <!-- 题图 -->
     <div class="page_bg">
         <h2>{!! $category->cate_name !!}</h2>
     </div>
     <!-- 正文 -->
     <div class="content_main">
         <h2 class="title">{!! $page->title !!}</h2>
         <div class="info">
             <span class="author">{!! isset($page->user->nick_name)?$page->user->nick_name:$page->user->user_name !!}</span>
             <span class="bull">•</span>
             <span class="time">{!! $page->published_at !!}</span>
             <span>浏览量 {!! $page->views_count !!}</span>
         </div>
         <div class="content">@if(!is_null($page->postContent)){!! $page->postContent->content !!}@endif</div>
     </div>
 @endsection
