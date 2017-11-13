<!-- 新闻中心 -->
<div class="news">
    <h2 class="title">{!! $category->cate_name !!}</h2>
    <ul class="news_list">
        @foreach($posts as $post)
            <li>
                @if(!is_null($post->cover))
                    <img src="{!! image_url($post->cover, 'post_cover_list') !!}">
                @endif
                <div class="news_info">
                    <a href="{!! $post->getPresenter()->url() !!}" title="{!! $post->title !!}">
                        <span class="title">@if($post->isTop())<span
                                    class="top">置顶</span>@endif{!! $post->getPresenter()->suitedTitle() !!}</span>
                        <p class="content">{!! $post->excerpt !!}</p>
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
    <a class="see_more"{!! $category->getPresenter()->linkAttribute() !!}>查看更多</a>
</div>
