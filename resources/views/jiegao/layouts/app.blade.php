<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@section('title') - 捷高科技 @show</title>
    <meta name="description" content="@section('description')@show">
    <meta name="keywords" content="@section('keywords')@show">
    <link rel="stylesheet" type="text/css" href="{{cdn('jiegao/css/normalize.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{cdn('jiegao/css/index.css')}}">
    <script type="text/javascript" src="{!! cdn('jiegao/lib/jquery/jquery.min.js') !!}"></script>
    @yield('css')
    @yield('js')
</head>
<body>
@yield('content')
@stack('js')
</body>
</html>