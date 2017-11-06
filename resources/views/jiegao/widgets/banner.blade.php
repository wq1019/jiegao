<div class="banner" id="banner">
    @php
        // 当banner小于4个时前端轮播图会出现问题，因此在这里手动复制一个banner
        if($banners->count() <4){
            $addBanners =clone $banners;
            foreach ($addBanners as $addBanner){
                 $banners->push($addBanner);
            }
        }
    @endphp
    @foreach($banners as $banner)
        <div>
            <a href="{!! $banner->url !!}" target="_blank">
                <img lazy src="{!! image_url($banner->image) !!}">
            </a>
        </div>
    @endforeach
</div>
