@extends('layouts.app')

@section('partial_css')
<style type="text/css">
    .contact {
        float: left;
        width: 500px;
    }

    .c_name {
        font-size: 1.2em;
        font-weight: bold;
    }
    .map {
        float: left;
        width: 200px;
    }
    .map img {
        margin-top: 25px;
    }

</style>
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
        <div class="col-lg-8 col-lg-offset-2">     
            <div class="contact">
                <p class="c_name">{{ trans('menu.company_name') }}</p>
                <p>{{ trans('menu.address') }}: {{ trans('menu.addinfo') }}</p>
                <p>{{ trans('menu.tel') }}: +86-755-22662313</p>
                <p>{{ trans('menu.email') }}: partner@QYsea.com</p>
                <p>{{ trans('menu.recruit') }}: careers@QYsea.com</p>

            </div>
            <div class="map">
                <img src="/img/contact_map.jpg" width="400" />
            </div>
        </div>
    </div>
</div>
@endsection
