@push('js')
    <script>

    </script>
@endpush

<!-- 轮播图 -->
<div class="ui-slider">
    <ul class="ui-slider-content">
        @foreach($banners as $banner)
            <li><a href="{!! $banner->url?:'javascript:;' !!}"
                   target="_blank"{!! empty($banner->title)?'':' title="'.$banner->title.'"' !!}>
                    <span style="background-image:url('{!! image_url($banner->image) !!}')">
                        @if(!empty($banner->title))
                            <p>{!! $banner->title !!}</p>
                        @endif</span></a></li>
        @endforeach
    </ul>
</div>