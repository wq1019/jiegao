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