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
      $(function () {
        var $searchForm = $('#search_form');
        $searchForm.find('input').keydown(function (e) {
          if (e.keyCode == 13) {
            $searchForm.submit();
          }
        })
      })
    </script>
@endpush
<div class="head">
    <div class="container">
        <a class="logo" href="#"><img src="{!! cdn('jiegao/images/logo.png') !!}" alt="{{setting('site_name')}}"></a>
        <div class="right">
            <span>服务热线：{{setting('phone')}}</span>
            <div class="search">
                <form id="search_form" action="{{route('frontend.web.search')}}" method="GET">
                    <input id="search_input" placeholder="请输入关键字搜索.." type="text" name="keywords">
                    <i class="search_icon" onclick="this.parentElement.submit()"></i>
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
                    <a title="{!! $category->cate_name !!}" {!! $category->equals($navigation->getActiveTopNav())?' class="active"':'' !!} {!! $category->getPresenter()->linkAttribute() !!}>{!! $category->cate_name !!}</a>
                    @if($category->hasChildren())
                        <div class="child">
                            @foreach($category->children as $children)
                                <a title="{!! $children->cate_name !!}" class="item"{!! $children->getPresenter()->linkAttribute() !!}>{!! $children->cate_name !!}</a>
                            @endforeach
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>
