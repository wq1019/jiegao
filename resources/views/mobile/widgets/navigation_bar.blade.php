@push('js')
    <script type="text/javascript">
      // 导航栏
      $(function () {
        setTimeout(function () {
          var navHeaderHeight = $('.nav_header').offset().height
          $('body').css('paddingTop', navHeaderHeight)
        }, 0)
        var scroll = new fz.Scroll('.ui-scroller', {
          scrollY: false,
          scrollX: true
        })
        var $headerNav = $('.header_nav')
        var $navLis = $headerNav.find('li')
        $headerNav.css('width', $navLis.width() * $navLis.length)
        scroll.refresh()
      })
    </script>
@endpush

<!-- 导航栏 -->
<div class="ui-scroller">
    <ul class="header_nav">
        <li>
            <a href="{!! route('frontend.web.index') !!}"{!! is_null($navigation->getActiveTopNav())?' class="active"':'' !!}>网站首页</a>
        </li>
        @foreach($allNav as $category)
            <li>
                <a{!! $category->is($navigation->getActiveTopNav())?' class="active"':'' !!}{!! $category->getPresenter()->linkAttribute() !!}>{!! $category->cate_name !!}</a>
            </li>
        @endforeach
    </ul>
</div>
@if(!is_null($navigation->getActiveTopNav()) && $navigation->getActiveTopNav()->hasChildren())
    <ul class="two_level_menu">
        @foreach($navigation->getActiveChildrenNav() as $category)
            <li>
                <a{!! $category->is($navigation->getActiveNav())?' class="active"':'' !!}{!! $category->getPresenter()->linkAttribute() !!}>{!! $category->cate_name !!}</a>
            </li>
        @endforeach
    </ul>
@endif
