<div class="head">
    <div class="container">
        <a class="logo" href="#"><img src="{!! cdn('jiegao/images/logo.png') !!}" alt="捷高电子科技"></a>
        <div class="phone"><i class="phone_icon"></i>{{setting('phone')}}</div>
    </div>
</div>
<div class="nav">
    <div class="container">
        <ul>
            <li{!! is_null($navigation->getActiveTopNav())?' class="active"':'' !!}>
                <a href="{!! route('frontend.web.index')!!}">网站首页</a>
            </li>
            @foreach($allNav as $category)
                <li{!! $category->equals($navigation->getActiveTopNav())?' class="active"':'' !!}>
                    <a{!! $category->getPresenter()->linkAttribute() !!}>{!! $category->cate_name !!}</a>
                    @if($category->hasChildren())
                        <div class="child">
                            @foreach($category->children as $children)
                                <a class="item"{!! $children->getPresenter()->linkAttribute() !!}>{!! $children->cate_name !!}</a>
                            @endforeach
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
