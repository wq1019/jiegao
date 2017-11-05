<div class="right">
    <h3>友情链接</h3>
    @foreach($links as $link)
        <a href="{!! $link->url !!}" title="{!! $link->name !!}" target="_blank">{!! $link->name !!}</a>
    @endforeach
</div>