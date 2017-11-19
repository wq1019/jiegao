@extends('jiegao.layouts.app')
@section('css')
    <link rel="stylesheet" type="text/css" href="{!! cdn('jiegao/lib/slick/slick.min.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! cdn('jiegao/lib/slick/slick-theme.min.css') !!}">
@endsection
@section('js')
    <script type="text/javascript" src="{!! cdn('jiegao/lib/slick/slick.min.js') !!}"></script>
@endsection
@section('keywords'){{ setting('default_keywords') }}@endsection
@section('description'){{ setting('default_description') }}@endsection
@section('title'){{ setting('site_name') }}@endsection

@section('content')
    @widget('navigation_bar')
    @widget('banner', ['type' => 'top_pic'])
    <div class="content">
        <div class="container">
            @php
                $categoryRepository = app(App\Repositories\CategoryRepository::class);
                $about = $categoryRepository->findByCateName('关于捷高');
                $aboutPage = $about->getPage();
            @endphp
            <div class="about">
                <div class="header">
                    <h2>{{$about->cate_name}}</h2>
                </div>
                <div class="info">
                    <img src="{!! image_url($about->image) !!}">
                    <p class="text">
                        {!! $aboutPage->excerpt !!}
                    </p>
                </div>
            </div>
            @widget('banner',['type'=>'corporate_environment','view'=>'corporate_environment_banner'])
        </div>
    </div>
    @php
        $categoryRepository = app(App\Repositories\CategoryRepository::class);
        $products = $categoryRepository->findByCateName('产品中心');
    @endphp
    <div class="prod">
        <div class="container">
            <div class="header">
                <h2>{{$products->cate_name}}</h2>
                <div class="line"></div>
            </div>
            <div class="main">
                @foreach(Facades\App\Widgets\PostList::mergeConfig(['category'=>$products,'limit'=>4])->getData()['posts'] as $post)
                    <div class="product_item">
                        <a title="{!! $post->title !!}" href="{!! $post->getPresenter()->url() !!}">
                            <img src="{!! image_url($post->cover) !!}" alt="{!! $post->title !!}">
                            <div class="mask_wrap">
                                <span>{!! $post->title !!}</span>
                                <div class="mask"></div>
                            </div>
                        </a>
						<p class="product_item_title">{!! $post->title !!}</p>
                    </div>
                @endforeach
				<div style="clear: both;"></div>
            </div>
            <div class="more">
                <a class="btn more_btn" {!! $products->getPresenter()->linkAttribute() !!}>查看更多</a>
            </div>
        </div>
    </div>
    @include('jiegao.layouts.particals.footer')
@endsection

@push('js')
    <script>
      $(function () {
        var $banner = $('#banner')
        if ($banner.children().length == 0)
          return
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
        var $envBanner = $('#env_banner')
        if ($envBanner.children().length == 0)
          return
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
        })
        $envBannerTitle = $('#env_banner_title');
        setEnvCurrentText();
        $envBanner.on('afterChange',function(event, slick, currentSlide){
          setEnvCurrentText();
        })
        function setEnvCurrentText () {
          var $currentText = $envBanner.find('.slick-current .text');
          $envBannerTitle.html($currentText.html());
        }
      })
    </script>
@endpush
