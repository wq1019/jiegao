@php
    // $banners = Facades\App\Widgets\Banner::mergeConfig(['type' => 'corporate_environment'])->getData()['banners'];
    // 当banner小于4个时前端轮播图会出现问题，因此在这里手动复制一个banner
    if($banners->count() <4){
        $addBanners =clone $banners;
        foreach ($addBanners as $addBanner){
             $banners->push($addBanner);
        }
    }
@endphp
<div class="env_banner">
    <div class="header">
        <h2>公司环境</h2>
        <div id="env_banner">
            @foreach($banners as $banner)
                <div>
                    <img lazy src="{!! image_url($banner->image) !!}">
                    <div class="text" style="display: none;">{{$banner->title}}</div>
                </div>
            @endforeach
        </div>
        <div class="footer">
            <p id="env_banner_title">title</p>
        </div>
    </div>
</div>