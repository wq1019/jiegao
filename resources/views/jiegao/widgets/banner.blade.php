<div class="banner" id="banner">
    @php
        // 当banner小于4个时前端轮播图会出现问题，因此在这里手动复制一个banner
        $count = $banners->count();
        if($count < 4){
            for ($i = 1; $i <= 4-$count; $i++) {
                $banners->push($banners[$i-1]);
            }
        }
    @endphp
    @foreach($banners as $banner)
        <div>
            <a title="{{ $banner->title or '' }}" href="{!! $banner->url !!}" target="_blank">
                <img lazy src="{!! image_url($banner->image) !!}">
            </a>
        </div>
    @endforeach
</div>
