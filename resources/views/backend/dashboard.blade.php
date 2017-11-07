<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ setting('site_name') }}</title>
    </head>
    <body>
        <div id="app"></div>
        <script>
            window.logo = "{{ config('tiny.logo', 'tiny') }}";
        </script>
        <script src="{{cdn('onlyGetPost.js')}}"></script>
        @include('vendor.ueditor.assets')
        <script src="{{cdn(mix('js/backend/app.js'))}}"></script>
    </body>
</html>
