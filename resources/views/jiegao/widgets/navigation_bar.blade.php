@push('js')
    <script>
      $('#nav>li').hover(function () {
        var $list = $(this).find('.child')
        $list.css('display', 'block');
        $list.stop().animate({
          'opacity': 1,
          'top': '60px'
        }, 200)
      }, function () {
        var $list = $(this).find('.child')
        $list.stop().animate({
          'opacity': 0,
          'top': '80px'
        }, 200, function () {
          if($list.css('top') == '70px'){
            $list.css('display', 'none');
          }
        })
      });
    </script>
@endpush
<div class="head">
    <div class="container">
        <a class="logo" href="#"><img src="{!! cdn('jiegao/images/logo.png') !!}" alt="捷高电子科技"></a>
        <div class="right">
            <span>服务热线：{{setting('phone')}}</span>
            <div class="search">
                <form id="search_form" action="index.php" method="GET">
                    <input id="search_input" placeholder="请输入关键字搜索.." type="text" name="keyword">
                    <i class="search_icon"></i>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="nav">
    <div class="container">
        <ul id="nav">
            <li>
                <a {!! is_null($navigation->getActiveTopNav())?' class="active"':'' !!} href="{!! route('frontend.web.index')!!}">网站首页</a>
            </li>
            @foreach($allNav as $category)
                <li>
                    <a {!! $category->equals($navigation->getActiveTopNav())?' class="active"':'' !!} {!! $category->getPresenter()->linkAttribute() !!}>{!! $category->cate_name !!}</a>
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
