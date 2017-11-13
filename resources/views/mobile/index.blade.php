@extends('mobile.layouts.default')

@section('title')首页@endsection
@section('js')

    <script type="text/javascript">
      // 轮播
      $(function () {
        var slider = new fz.Scroll('.ui-slider', {
          role: 'slider',
          indicator: true,
          autoplay: true,
          interval: 3000
        })
      })

    </script>

@endsection

@section('content')
    <!-- 轮播图 -->
    @widget('banner', ['type' => 'top_pic'])
    @widget('product')
    @widget('news')

@endsection
