<!-- 产品中心 -->
<div class="product">
    <h2 class="title">{!! $category->cate_name !!}</h2>
    <ul class="product_list">
        @foreach($posts as $post)
            <li>
                <div class="img_info">
                    <a href="{!! $post->getPresenter()->url() !!}">
                        <img src="{!! image_url($post->cover,'product_cover_index') !!}">
                        <p class="title">{!! $post->title !!}</p>
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
    <a class="see_more"{!! $category->getPresenter()->linkAttribute() !!}>查看更多</a>
</div>