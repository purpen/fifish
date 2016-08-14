<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Fifish - 后台管理</title>

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ elixir('css/base.css') }}" rel="stylesheet">
    
    @yield('partial_css')
    
    <style>
        body {
            padding-top: 50px;
        }
        .sub-header {
            border-bottom: 1px solid #eee;
            padding-bottom: 10px;
        }
        .navbar-fixed-top {
            border: 0 none;
        }
        .sidebar {
            display: none;
        }
        @media (min-width: 768px) {
            .sidebar {
                background-color: #f5f5f5;
                border-right: 1px solid #eee;
                bottom: 0;
                display: block;
                left: 0;
                overflow-x: hidden;
                overflow-y: auto;
                padding: 20px;
                position: fixed;
                top: 51px;
                z-index: 1000;
            }
        }
        .nav-sidebar {
            margin-bottom: 20px;
            margin-left: -20px;
            margin-right: -21px;
        }
        .nav-sidebar > li > a {
            padding-left: 20px;
            padding-right: 20px;
        }
        .nav-sidebar > .active > a, 
        .nav-sidebar > .active > a:hover, 
        .nav-sidebar > .active > a:focus {
            background-color: #428bca;
            color: #fff;
        }
        .main {
            padding: 20px;
        }
        @media (min-width: 768px) {
            .main {
                padding-left: 40px;
                padding-right: 40px;
            }
        }
        .main .page-header {
            margin-top: 0;
        }
        .table > tbody > tr > td {
            vertical-align: middle;
        }
        .placeholders {
            margin-bottom: 30px;
            text-align: center;
        }
        .placeholders h4 {
            margin-bottom: 0;
        }
        .placeholder {
            margin-bottom: 20px;
        }
        .placeholder img {
            border-radius: 50%;
            display: inline-block;
        }
        .page-tools {
            margin: 10px auto 20px;
        }
        
        @yield('customize_css')
    </style>
</head>
<body id="app-layout">
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">Fifish Admin</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="#">设置</a></li>
                    <li><a href="#">帮助？</a></li>
                </ul>
                <form class="navbar-form navbar-right">
                    <input type="text" class="form-control" placeholder="Search...">
                </form>
            </div>
        </div>
    </nav>
        
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li>
                        <a href="/admin">
                            <span class="glyphicon glyphicon-stats" aria-hidden="true"></span> 概述 </a>
                    </li>
                    <li class="active">
                        <a href="/admin/stuffs">
                            <span class="glyphicon glyphicon-camera" aria-hidden="true"></span> 分享管理
                        </a>
                    </li>
                    <li>
                        <a href="/admin/tags">
                            <span class="glyphicon glyphicon-tags" aria-hidden="true"></span> 标签管理
                        </a>
                    </li>
                    <li>
                        <a href="/admin/assets">
                            <span class="glyphicon glyphicon-paperclip" aria-hidden="true"></span> 附件管理
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-sidebar">
                    <li>
                        <a href="/admin/users">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>  用户管理
                        </a>
                    </li>
                </ul>
                <ul class="nav nav-sidebar">
                    <li>
                        <a href="/admin/">
                            <span class="glyphicon glyphicon-stats" aria-hidden="true"></span> 数据统计
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                <!-- Display Validation Errors -->
                @include('common.errors')
                
                @yield('content')
            </div>
        </div>
    <div>
        
    @yield('footer')
    <!-- JavaScripts -->
    <script src="{{ asset('js/jquery-3.0.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    {{-- <script src="{{ elixir('js/base.js') }}"></script> --}}
</body>
</html>
