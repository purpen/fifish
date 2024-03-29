<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FIFISH P4 @yield('title')</title>

    <!-- Fonts -->

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.plugins.min.css') }}" rel="stylesheet"> 
    <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
    
    @yield('partial_css')
    
    <style type="text/css">
        .fa-btn {
            margin-right: 6px;
        }
        .page-header {
            margin-top: 10px;
        }
        .page-tools {
            margin: 10px auto;
        }
        .dropdown button {
            background-color: rgba(255, 255, 255, 0);
           border: medium none;
           margin: 0 !important;
           padding: 0 !important;
        }
        .dropdown-menu {
            min-width: 90px;
        }
        .dropdown-menu > li > a {
            padding: 0 5px;
        }
        
        @yield('customize_css')
    </style>
</head>
<body id="app-layout">
    @yield('header')
    <nav class="navbar navbar-black navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/img/fifish_logo.png" />
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <!--<li><a href="{{ url('/home') }}">{{ trans('menu.home') }}</a></li>-->
                    <!--<li><a href="{{ url('/product') }}">{{ trans('menu.product') }}</a></li>-->
                    <li><a href="{{ url('/p4') }}" class="{{ $sub_menu_p4 or '' }}">P4</a></li>
                    <li><a href="{{ url('/news') }}" class="{{ $sub_menu_news or '' }}">{{ trans('menu.media') }}</a></li>
                    <li><a href="{{ url('/recruit') }}" class="{{ $sub_menu_recruit or '' }}">{{ trans('menu.recruit') }}</a></li>
                    <li><a href="{{ url('/aboutus') }}" class="{{ $sub_menu_aboutus or '' }}">{{ trans('menu.aboutus') }}</a></li>
                    <li><a href="{{ url('/contact') }}" class="{{ $sub_menu_contact or '' }}">{{ trans('menu.contactus') }}</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <!-- Authentication Links -->
                <!--
                <ul class="nav navbar-nav navbar-right">
                    
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">登录</a></$('.selectpicker').selectpicker('selectAll');li>
                        <li><a href="{{ url('/register') }}">注册</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->username }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                 <li><a href="{{ url('/admin') }}"><i class="fa fa-btn"></i>后台管理</a></li>
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>安全退出</a></li>
                            </ul>
                        </li>
                    @endif
                </ul-->
            </div>
        </div>
    </nav>

    @yield('content')

    @include('block.footer')
    
    @yield('footer')
    <!-- JavaScripts -->
    <script src="{{ asset('js/jquery-3.0.0.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ elixir('js/jquery.plugins.min.js') }}" type="text/javascript"></script>
    <script src="{{ elixir('js/app.js') }}" type="text/javascript"></script>
    @yield('script')
    <script type="text/javascript">
        $(function(){
            
            function formatState (state) {
              if (!state.id) { return state.text; }
              var $state = $(
                '<span><img src="/img/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
              );
              return $state;
            };

            $(".lang-choose").select2({
                minimumResultsForSearch: Infinity,
                templateResult: formatState,
                templateSelection: formatState,
                width: 110
            }).on('change', function (evt) {
                var lang = $(this).val();
                window.location.href = '/lang/'+lang;
            });
            
            @yield('jquery')
        });
    </script>
</body>
</html>
