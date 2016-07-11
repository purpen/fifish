<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')-Fifish</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ elixir('css/base.css') }}">
    @yield('partial_css')
    
    <style type="text/css">
        @yield('customize_css')
    </style>
    
</head>
<body id="app-layout">
    
    @yield('header')

    @yield('content')
    
    @yield('footer')

    <!-- JavaScripts -->
    <script src="{{ asset('js/jquery-3.0.0.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/base.js') }}"></script>
    <!--[if lte IE 8]>
        <script src="{{ asset('js/html5shiv.min.js') }}" type="text/javascript"></script>
     <![endif]-->

    @yield('partial_js')
    <script type="text/javascript">
        @yield('customize_js')
    </script>
</body>
</html>

