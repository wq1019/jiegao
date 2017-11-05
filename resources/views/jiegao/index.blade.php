@extends('jiegao.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{!! cdn('jiegao/lib/slick/slick.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! cdn('jiegao/lib/slick/slick-theme.min.css') !!}">
@endsection
@section('js')
    <script type="text/javascript" src="{!! cdn('jiegao/lib/jquery/jquery.min.js') !!}"></script>
    <script type="text/javascript" src="{!! cdn('jiegao/lib/slick/slick.min.js') !!}"></script>
@endsection
@section('keywords'){{ setting('default_keywords') }}@endsection
@section('description'){{ setting('default_description') }}@endsection
@section('title'){{ setting('site_name') }}@endsection

@section('content')
    @include('jiegao.layouts.particals.navigation')
    @include('jiegao.layouts.particals.banner')
    <div class="content">
        <div class="container">
            <div class="about">
                <div class="header">
                    <h2>关于捷高</h2>
                </div>
                <div class="info">
                    <img src="{!! cdn('jiegao/images/about.png') !!}">
                    <p class="text">
                        我们的流线式网页布局设计方案和可视化图文内容编辑模式让网站制作和维护成为一件轻松惬意的事。无论您是普通互联页设计出最制作人页设计出最制作人作人页设计出最制作人页设计出最制作人作人计出最制作人作人页设人
                        我们的流线式网页布局设计方案和可视化图文内容编辑模式让网站制作和维护成为一件轻松惬意的事。无论您是普通互联页设计出最制作人页设计出最制作人作人页设计出最制作人页设计出最制作人作人计出最制作人作人页设人
                    </p>
                </div>
            </div>
            <div class="env_banner">
                <div class="header">
                    <h2>公司环境</h2>
                    <div id="env_banner">
                        <img lazy src="{!! cdn('jiegao/images/env.png') !!}">
                        <img lazy src="{!! cdn('jiegao/images/env.png') !!}">
                        <img lazy src="{!! cdn('jiegao/images/env.png') !!}">
                        <img lazy src="{!! cdn('jiegao/images/env.png') !!}">
                        <img lazy src="{!! cdn('jiegao/images/env.png') !!}">
                    </div>
                    <div class="footer">
                        <p>生产车间</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="prod">
        <div class="container">
            <div class="header">
                <h2>产品中心</h2>
                <div class="line"></div>
            </div>
            <div class="main">
                <div class="product_item">
                    <a href="#">
                        <img src="{!! cdn('jiegao/images/prod1.png') !!}" alt="">
                        <div class="mask_wrap">
                            <span>产品01</span>
                            <div class="mask"></div>
                        </div>
                    </a>
                </div>
                <div class="product_item">
                    <a href="#">
                        <img src="{!! cdn('jiegao/images/prod2.png') !!}" alt="">
                        <div class="mask_wrap">
                            <span>产品02</span>
                            <div class="mask"></div>
                        </div>
                    </a>
                </div>
                <div class="product_item">
                    <a href="#">
                        <img src="{!! cdn('jiegao/images/prod3.png') !!}" alt="">
                        <div class="mask_wrap">
                            <span>产品03</span>
                            <div class="mask"></div>
                        </div>
                    </a>
                </div>
                <div class="product_item">
                    <a href="#">
                        <img src="{!! cdn('jiegao/images/prod4.png') !!}" alt="">
                        <div class="mask_wrap">
                            <span>产品04</span>
                            <div class="mask"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="more">
                <a class="btn more_btn" href="#">查看更多</a>
            </div>
        </div>
    </div>
    @include('jiegao.layouts.particals.footer')
@endsection

@push('js')
    <script>
      $(function () {
        var $banner = $("#banner");
        if($banner.children().length == 0)
          return;
        $banner.slick({
          dots: true,
          infinite: true,
          centerMode: true,
          variableWidth: true,
          autoplay: true,
          autoplaySpeed: 5000,
          slidesToShow: 3,
          slidesToScroll: 3,
          arrows: false
        });
        var $envBanner = $('#env_banner');
        if($envBanner.children().length == 0)
          return;
        $envBanner.slick({
          dots: false,
          infinite: true,
          centerMode: true,
          variableWidth: true,
          autoplay: true,
          autoplaySpeed: 5000,
          slidesToShow: 3,
          slidesToScroll: 3,
          arrows: true
        });
      });
    </script>
@endpush
