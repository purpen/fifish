@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h5>关于FIFISH</h5>
        </div>
        <div class="col-lg-4 text-right">
            <h5 class="subnav">
                <a href="{{ url('/aboutus') }}" class="{{ $sub_menu_aboutus or '' }}">关于我们</a> 
                <a href="{{ url('/contact') }}" class="{{ $sub_menu_contact or '' }}">联系我们</a>
            </h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="banner banner-contact">
              <h4 class="text-center">联系我们</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 text-center">     
            <div class="contact">       
                <p>Email: sales@qysea.com</p>
                <p>电话:+86-0755-22662313</p>
                <p>地址：广东省深圳市福田保税区花样年福年广场B4栋627、629室 </p>
            </div>
        </div>
    </div>
</div>
@endsection