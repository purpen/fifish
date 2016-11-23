@extends('layouts.app')

@section('jquery')
    var mySwiper = new Swiper('.swiper-container', {
        loop: true,

        pagination: '.swiper-pagination',
        paginationClickable: true
    });
@endsection

@section('content')
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide cover" style="background-image: url( {{ url('/img/top01.jpg') }} )">
            <div class="container caption">
                <img src="/img/ceslogo.png" class="ces-logo">
                <h3>Fifish P4 <br><span>荣获CES 2017创新大奖</span></h3>
                <a href="" class="btn btn-white">
                    观看视频 <i class="icon-play-circle"></i>
                </a>
            </div>
        </div>
        <div class="swiper-slide cover" style="background-image: url( {{ url('/img/top02.jpg') }} )">
            <div class="container caption-right">
                <h3>Fifish P4 <br><span>亮相布尔诺国际机械工业博览会</span></h3>
            </div>
        </div>
    </div>
    <!-- 如果需要分页器 -->
    <div class="swiper-pagination"></div>
</div>

<div class="block products">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="block-title white">
                    <span>{{ trans('menu.productshow') }}</span>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 item">
                <img src="/img/1.jpg" class="photo">
            </div>
            <div class="col-md-6 item">
                <img src="/img/2.jpg" class="photo">
            </div>
            <div class="col-md-6 item">
                <img src="/img/3.jpg" class="photo">
            </div>
            <div class="col-md-6 item">
                <img src="/img/4.jpg" class="photo">
            </div>
        </div>
    </div>
</div>

<div class="block news">
    <div class="container">
        <div class="row">
            <h2 class="block-title text-center">
                <span>{{ trans('menu.news') }}</span>
            </h2>
        </div>
        <div class="row">
            @foreach ($columns as $column)
            <div class="col-md-4">
                <div class="thumbnail card">
                    <a href="{{ $column->url }}" target="_blank">
                        <img src="{{ $column->cover ? $column->cover->file->adpic : '' }}" alt="{{ $column->title }}">
                    </a>
                    <div class="caption">
                        <h3>
                            <a href="" target="_blank">{{ $column->title }}</a>
                        </h3>
                        <p>
                            <span class="text-blue">{{ $column->sub_title }}</span>
                            <span class="pull-right text-time">{{ $column->summary }}</span>
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row text-center">
            <a href="{{ url('/news') }}" class="btn btn-blue btn-lg btn-more">查看更多</a>
            <div class="mideas mt-2r">
                <img src="/img/media/36kr.png" class="logo">
                <img src="/img/media/technode.png" class="logo">
                <img src="/img/media/geekpark.png" class="logo">
                <img src="/img/media/net163.png" class="logo">
                <img src="/img/media/sina.png" class="logo">
            </div>
        </div>
    </div>
</div>

<div class="block about white">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <h2 class="block-title white">
                    <span>{{ trans('menu.aboutus') }}</span>
                </h2>
            </div>
            <div class="col-md-8 col-md-offset-2">
                <p>{{ trans('aboutme.info') }}</p>
                <p>{{ trans('aboutme.info2') }}</p>
            </div>
        </div>
    </div>
</div>

<div class="block contact">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <h2 class="block-title">
                    <span>{{ trans('menu.contactus') }}</span>
                </h2>
                <p>{{ trans('menu.email') }}: sales@qysea.com</p>
                <p>{{ trans('menu.tel') }}：+86-0755-022662313</p>
                <p>{{ trans('menu.address') }}：{{ trans('menu.addinfo') }}</p>
            
                <div class="social-buttons">
                    <a href="" class="qq">QQ</a>
                    <a href="" class="weibo">微博</a>
                    <a href="" class="wechat">微信</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!--div class="container focus">
    <div class="row">
        <div class="col-lg-4">
            <div class="focus-item tutorials">
                <h4>新手教程</h4>
                <div class="transparent"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="focus-item video">
                <h4>视频集锦</h4>
                <div class="transparent"></div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="focus-item event">
                <h4>精彩活动</h4>
                <div class="transparent"></div>
            </div>
        </div>
    </div>
</div-->
@endsection
