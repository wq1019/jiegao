<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>@section('title')Powered by tiny @show - 捷高汽车电子</title>
    <link rel="stylesheet" href="{!! asset('static/mobile/css/frozen.css') !!}">
    <link rel="stylesheet" type="text/css" href="{!! asset('static/mobile/css/com.css') !!}">
</head>
<body>
<div class="nav_header">
    <div class="top_line"></div>
    @widget('navigation_bar')
</div>

@yield('content')
<div class="friend_link">
    <h2 class="title">友情链接</h2>
    @widget('link', ['type' => 'friendship_links'])
</div>
<div id="toTop" class="to_top">
    <img src="{!! asset('static/mobile/images/top.png') !!}">
</div>
<div class="footer">
    <p>安徽淮南汽车电子公司版权所有</p>
    <p>Copyright © 2017 {{setting('record_number')}}</p>
</div>
<script src="{!! asset('static/mobile/lib/zeptojs/zepto.min.js') !!}"></script>
<script src="{!! asset('static/mobile/lib/frozen.js') !!}"></script>
<script>
  // 导航栏细化
  $(function () {
    var navHeader = $('.nav_header')
    var navHeaderHeight = navHeader.height()
    var beforeScrollTop = document.body.scrollTop
    window.addEventListener('scroll', function () {
      var afterScrollTop = document.body.scrollTop,
        delta = afterScrollTop - beforeScrollTop
      beforeScrollTop = afterScrollTop
      if (navHeaderHeight <= document.body.scrollTop && delta > 0) {
        navHeader.css({
          'transform': 'translateY(-' + navHeaderHeight + 'px)'
        })
      } else {
        navHeader.css({
          'transform': 'translateY(0)'
        })
      }
    })
    // 回到顶部
    var onTop = $('#toTop')
    window.addEventListener('scroll', function () {
      document.body.scrollTop > 200 ? onTop.css('display', 'block') : onTop.css('display', 'none')
    })
    onTop.on('click', function () {
      $('body').scrollTop(0)
    })
  })
</script>
@yield('js')
@stack('js')
</body>
</html>
