<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Fifish P4</title>
        <!-- Styles -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/bootstrap.plugins.min.css') }}" rel="stylesheet"> 
        <link href="{{ elixir('css/app.css') }}" rel="stylesheet">
        <link href="{{ elixir('css/wap.css') }}" rel="stylesheet">
        <style>
            @yield('customize_css')
        </style>
    </head>

    <body id="wap-layout">
        @include('block.mini-header')
        
        @yield('content')
        
        @include('block.mini-footer')
        <!-- JavaScripts -->
        <script src="{{ asset('js/jquery-3.0.0.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ elixir('js/jquery.plugins.min.js') }}" type="text/javascript"></script>
        <script src="{{ elixir('js/app.js') }}" type="text/javascript"></script>
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