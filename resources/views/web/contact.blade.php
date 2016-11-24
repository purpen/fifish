@extends('layouts.app')

@section('content')
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
 
<div class="banner banner-contact">
    <h4 class="text-center block-title white">
        <span>{{ trans('menu.contactus') }}</span>
    </h4>
</div>

<div class="container">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 text-center">     
            <div class="contact">     
                <p>{{ trans('menu.email') }}: sales@qysea.com</p>
                <p>{{ trans('menu.tel') }}：+86-0755-022662313</p>
                <p>{{ trans('menu.address') }}：{{ trans('menu.addinfo') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection