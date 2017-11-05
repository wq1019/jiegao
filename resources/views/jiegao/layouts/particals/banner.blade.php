<div class="banner" id="banner">
    @php
        $banners = Facades\App\Widgets\Banner::mergeConfig(['type' => 'top_pic'])->getData()['banners'];
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
        {{--@if($loop->last	&& $loop->count<4)
            @for($i = 1; $i<=4-$loop->count; $i++)
                <div>
                    <a href="{!! $banner->url !!}" target="_blank">
                        <img lazy src="{!! image_url($banner->image) !!}">
                    </a>
                </div>
            @endfor
        @endif--}}
    @endforeach
</div>
