@extends('jiegao.layouts.app');

@section('keywords'){{ setting('default_keywords') }}@endsection
@section('description'){{ setting('default_description') }}@endsection
@section('title'){{ setting('site_name') }}@endsection

@section('content')
    @include('jiegao.layouts.particals.navigation')
    <!-- 列表正文start -->
    <div class="list_top_bg"></div>
    <div class="list_container container">
        <div class="nav_menu">
            <ul>
                <li class="active">
                    <span class="pendant"></span>
                    <a href="#">招生就业</a>
                    <span class="arrow"></span>
                </li>
                <li>
                    <span class="pendant"></span>
                    <a href="#">招生计划</a>
                    <span class="arrow"></span>
                </li>
                <li>
                    <span class="pendant"></span>
                    <a href="#">就业工程</a>
                    <span class="arrow"></span>
                </li>
            </ul>
        </div>
        <div class="main_list">
            <div class="header">
                <ol class="breadcrumb">
                    <li>
                        <a href="http://211.70.176.153">首页</a>
                    </li>
                    <li class="active">招生就业</li>
                </ol>
            </div>
            <ul class="post_list">
                <li>
                    <a href="#">【砥砺奋进 继往开来 】360集团组织骨干员工观看十九大</a>
                    <span class="time">2017-11-1</span>
                </li>
                <li>
                    <a href="#">【砥砺奋进 继往开来 】360集团组织骨干员工观看十九大</a>
                    <span class="time">2017-11-1</span>
                </li>
                <li>
                    <a href="#">【砥砺奋进 继往开来 】360集团组织骨干员工观看十九大</a>
                    <span class="time">2017-11-1</span>
                </li>
                <li>
                    <a href="#">【砥砺奋进 继往开来 】360集团组织骨干员工观看十九大</a>
                    <span class="time">2017-11-1</span>
                </li>
                <li>
                    <a href="#">【砥砺奋进 继往开来 】360集团组织骨干员工观看十九大</a>
                    <span class="time">2017-11-1</span>
                </li>
            </ul>
            <ul class="pagination">
                <li class="disabled">
                    <span>«</span>
                </li>
                <li class="active">
                    <span>1</span>
                </li>
                <li>
                    <a href="#">2</a>
                </li>
                <li>
                    <a href="#">3</a>
                </li>
                <li>
                    <a href="#">4</a>
                </li>
                <li>
                    <a href="#">5</a>
                </li>
            </ul>
        </div>
    </div>
    <!-- 列表正文end -->
    @include('jiegao.layouts.particals.footer')
@endsection


