@extends('layouts.app')

@section('partial_css')
<style type="text/css">
    .c-title {
        margin-bottom: 20px;
        margin-top: 30px;
        font-size: 1.2em;
    }
    .c-content {
        margin: 0 0 30px 40px;
    }
    .sub-title {
        font-weight: bold;
    }

    .line_m{
        text-decoration:line-through;
        color: #ccc;
    }
    p {
        font-family: PmingLiu
    }

</style>
@endsection

@section('content')

<!--
<div class="container insmenu">
    <div class="row">
        <div class="col-lg-8">
            <h5>{{ trans('menu.aboutus') }}</h5>
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
    
<div class="banner">
    <h4 class="text-center block-title white">
        <span>{{ trans('menu.aboutus') }}</span>
    </h4>
</div> 

<div class="container">   
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">

            <div>
                <div class="text-center c-title"><span class="line_m">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="sub-title">{{ trans('aboutme.about_title_01') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="line_m">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                <div class="c-content">
                    <p>{{ trans('aboutme.about_content_01_01') }}</p>
                    <p>{{ trans('aboutme.about_content_01_02') }}</p>

                </div>
            </div>

            <div>
                <div class="text-center c-title"><span class="line_m">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="sub-title">{{ trans('aboutme.about_title_02') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="line_m">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                <div class="c-content">
                    <p>{{ trans('aboutme.about_content_02_01') }}</p>
                    <p>{{ trans('aboutme.about_content_02_02') }}</p>
                    <p>{{ trans('aboutme.about_content_02_03') }}</p>
                    <p>{{ trans('aboutme.about_content_02_04') }}</p>
                    <p>{{ trans('aboutme.about_content_02_05') }}</p>
                </div>

            </div>

            <div>
                <div class="text-center c-title"><span class="line_m">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="sub-title">{{ trans('aboutme.about_title_03') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="line_m">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                <div class="c-content">
                    <p>{{ trans('aboutme.about_content_03_01') }}</p>
                    <p>{{ trans('aboutme.about_content_03_02') }}</p>
                    <p>{{ trans('aboutme.about_content_03_03') }}</p>
                    <p>{{ trans('aboutme.about_content_03_04') }}</p>
                    <p>{{ trans('aboutme.about_content_03_05') }}</p>
                    <p>{{ trans('aboutme.about_content_03_06') }}</p>
                    <p>{{ trans('aboutme.about_content_03_07') }}</p>
                    <p>{{ trans('aboutme.about_content_03_08') }}</p>
                    <p>{{ trans('aboutme.about_content_03_09') }}</p>
                    <p>{{ trans('aboutme.about_content_03_10') }}</p>
                    <p>{{ trans('aboutme.about_content_03_11') }}</p>
                    <p>{{ trans('aboutme.about_content_03_12') }}</p>

                </div>

            </div>

            <!--
            <div class="aboutus">       
                <p>{{ trans('aboutme.info') }}</p>
                <p>
                    {{ trans('aboutme.info2') }}
                </p>
            </div>
            -->
        </div>
    </div>
</div>
@endsection
