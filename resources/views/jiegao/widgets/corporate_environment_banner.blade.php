@php
    // 当banner小于4个时前端轮播图会出现问题，因此在这里手动复制一个banner
    $count = $banners->count();
    if($count < 4){
        for ($i = 1; $i <= 4-$count; $i++) {
            $banners->push($banners[$i-1]);
        }
    }
@endphp
<div class="env_banner">
    <div class="header">
        <h2>公司环境</h2>
        <div id="env_banner">
            @foreach($banners as $banner)
                <div>
                    <img title="{{$banner->title or ''}}" lazy src="{!! image_url($banner->image) !!}">
                    <div class="text" style="display: none;">{{ $banner->title or '' }}</div>
                </div>
            @endforeach
        </div>
        <div class="footer">
            <p id="env_banner_title">title</p>
        </div>
    </div>
</div>