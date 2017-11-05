<div class="nav_menu">
    <ul>
        <li @if($navigation->getActiveNav()->equals($navigation->getActiveTopNav()))class="active"@endif>
            <span class="pendant"></span>
            <a{!! $navigation->getActiveTopNav()->getPresenter()->linkAttribute() !!}>{!! $navigation->getActiveTopNav()->cate_name !!}</a>
            <span class="arrow"></span>
        </li>
        @foreach($navigation->getActiveChildrenNav() as $childNav)
            <li @if($childNav->equals($navigation->getActiveNav()))class="active"@endif>
                <span class="pendant"></span>
                <a{!! $childNav->getPresenter()->linkAttribute() !!}>{!! $childNav->cate_name !!}</a>
                <span class="arrow"></span>
            </li>
        @endforeach
    </ul>
</div>