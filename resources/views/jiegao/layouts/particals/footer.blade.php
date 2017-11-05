<div class="bottom_footer">
    <div class="container">
        <div class="left">
            <h3>联系我们</h3>
            <p>{{setting('site_name')}}</p>
            <p>地址：{{ setting('address') }}</p>
            <p>邮编：{{ setting('zip_code') }}</p>
        </div>
        @widget('link', ['type' => 'friendship_links'])
        <div style="clear: both;"></div>
        <div class="copy">
            {!! setting('copy_right') !!}
        </div>
    </div>
</div>
