@extends('layouts.app')

@section('content')
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
    
<div class="banner">
    <h4 class="text-center block-title white">
        <span>{{ trans('menu.aboutus') }}</span>
    </h4>
</div> 

<div class="container">   
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 text-center">     
            <div class="aboutus">       
                <p>{{ trans('aboutme.info') }}</p>
                <p>
                    {{ trans('aboutme.info2') }}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection