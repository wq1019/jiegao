<ul>
@foreach($links as $link)
    <li>
        <a href="{!! $link->url !!}" target="_blank">{!! $link->name !!}</a>
    </li>
@endforeach
</ul>