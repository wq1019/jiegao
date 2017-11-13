@extends('mobile.layouts.default')


@section('js')
    <script type="text/javascript">
      var currentPage = {!! $posts->currentPage() !!}
      var lastPage = {!! $posts->lastPage() !!}
      var page_url = '{!! route('frontend.web.category.show', $category->cate_slug) !!}'
      var isEnd = true

      function loadMore () {
        let scrollTop = document.documentElement.scrollTop || window.pageYOffset || document.body.scrollTo
        var spinner = $('.spinner')
        if (document.documentElement.scrollHeight - 100 <= document.documentElement.clientHeight + scrollTop) {
          spinner.show()
          if (isEnd) {
            isEnd = false
            $.get(page_url + '?page=' + (++currentPage), function (data) {
              isEnd = true
              spinner.hide()
              $newList.append(data)
            })
            if (currentPage > lastPage) {
              window.removeEventListener('scroll', loadMore)
              spinner.hide()
            }
          }
        }
      }

      $(function () {
        $newList = $('#news_list')
        window.addEventListener('scroll', loadMore)
      })
    </script>

@endsection

@section('title'){!! $category->cate_name !!}@endsection

@section('content')
    <!-- 题图 -->
    <div class="page_bg">
        <h2>{!! $category->cate_name !!}</h2>
    </div>
    <!-- 新闻中心 -->
    <div class="news">
        <ul id="news_list" class="news_list">
            @forelse($posts as $post)
                <li>
                    @if(!is_null($post->cover))
                        <img src="{!! image_url($post->cover, 'post_cover_list') !!}">
                    @endif
                    <div class="news_info">
                        <a href="{!! $post->getPresenter()->url() !!}">
                            <span class="title">@if($post->isTop())<span class="top">置顶</span>@endif{!! $post->title !!}</span>
                            <p class="content">{!! $post->excerpt !!}</p>
                        </a>
                    </div>
                </li>
            @empty
                <li>暂无文章</li>
            @endforelse
        </ul>
    </div>
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
@endsection

