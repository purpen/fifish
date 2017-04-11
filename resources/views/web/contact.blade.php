@extends('layouts.app')

@section('partial_css')
<style type="text/css">
    .contact {
        float: left;
        width: 450px;
    }

    .c_name {
        font-size: 1.2em;
        font-weight: bold;
    }
    .map {
        float: left;
        width: 490px;
        height: 280px;
        margin-top: 20px;
    }

</style>
@endsection

@section('script')
<script type="text/javascript">
    function initialize() {  
      var mp = new BMap.Map('map');  
      var point = new BMap.Point(114.064576,22.512459);
      mp.centerAndZoom(point, 17);  
      var marker = new BMap.Marker(point);  // 创建标注
	    mp.addOverlay(marker);              // 将标注添加到地图中
    }  
       
    function loadScript() {  
      var script = document.createElement("script");  
      script.src = "https://api.map.baidu.com/api?v=2.0&ak=N8Y86jHulT4qDOAmLb47vU7y&callback=initialize";//此为v2.0版本的引用方式  
      // http://api.map.baidu.com/api?v=1.4&ak=N8Y86jHulT4qDOAmLb47vU7y&callback=initialize"; //此为v1.4版本及以前版本的引用方式  
      document.body.appendChild(script);  
    }  
       
    window.onload = loadScript; 
</script>
@endsection

@section('content')

<!--
<div class="container insmenu">
    <div class="row">
        <div class="col-lg-8">
            <h5>{{ trans('menu.contactus') }}</h5>
        </div>
        <div class="col-lg-4 text-right">
            <h5 class="subnav">
                <a href="{{ url('/aboutus') }}" class="{{ $sub_menu_aboutus or '' }}">{{ trans('menu.aboutus') }}</a> 
                <a href="{{ url('/contact') }}" class="{{ $sub_menu_contact or '' }}">{{ trans('menu.contactus') }}</a>
            </h5>
        </div>
    </div>
</div> 
-->
 
<div class="banner banner-contact">
    <h4 class="text-center block-title white">
        <span>{{ trans('menu.contactus') }}</span>
    </h4>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">     
            <div class="contact">
                <p class="c_name">{{ trans('menu.company_name') }}</p>
                <p>{{ trans('menu.address') }}: {{ trans('menu.addinfo') }}</p>
                <p>{{ trans('menu.tel') }}: +86-755-22662313</p>
                <p>{{ trans('menu.email') }}: partner@qysea.com</p>
                <p>{{ trans('menu.recruit') }}: careers@qysea.com</p>

            </div>
            <div class="map" id="map"></div>
        </div>
    </div>
</div>
@endsection
