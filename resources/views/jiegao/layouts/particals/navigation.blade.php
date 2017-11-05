@php
    $home = route('frontend.web.index');
@endphp
<div class="head">
    <div class="container">
        <a class="logo" href="#"><img src="{!! cdn('jiegao/images/logo.png') !!}" alt="捷高电子科技"></a>
        <div class="phone"><i class="phone_icon"></i>{{setting('phone')}}</div>
    </div>
</div>
<div class="nav">
    <div class="container">
        <ul>
            <li><a href="{{$home}}">网站首页</a></li>
            @foreach(Facades\App\Widgets\NavigationBar::getData()['allNav'] as $nav)
                <li><a {!! $nav->getPresenter()->linkAttribute() !!} >{{$nav->cate_name}}</a></li>
            @endforeach
        </ul>
    </div>
</div>
