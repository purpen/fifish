<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fifish</title>
        <!-- Styles -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
        <style type="text/css">
            #app-layout {
                max-width: 720px;
                margin: 0 auto;
            }
            #app-layout .container-fluid {
                padding-right: 0;
                padding-left: 0;
            }
            @yield('customize_css')
        </style>
    </head>

    <body id="app-layout">
        @yield('header')
        @yield('content')
        @yield('footer')
        <!-- JavaScripts -->
        <script src="{{ asset('js/jquery-3.0.0.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ elixir('js/jquery.plugins.min.js') }}" type="text/javascript"></script>
        <script src="{{ elixir('js/app.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            $(function(){
                @yield('jquery')
            });
        </script>
    </body>
</html>