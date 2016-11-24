@extends('layouts.wap')

@section('jquery')
    var video = document.getElementById('fifish-v1');
    var mySwiper = new Swiper('.swiper-adv', {
        loop: true,
        autoplay: 3000,
        pagination: '.swiper-pagination',
        paginationClickable: true
    });
    var proSwiper = new Swiper('.swiper-products', {
        slidesPerView: 'auto',
        spaceBetween: 50
    });
    var newSwiper = new Swiper('.swiper-news', {
        slidesPerView: 'auto',
        spaceBetween: 30
    });
    
    $('#video-box').on('hide.bs.modal', function(e){
        mySwiper.startAutoplay();
        video.pause();
    }).on('show.bs.modal', function(e){
        mySwiper.stopAutoplay();
    });
@endsection

@section('content')
<div class="swiper-container swiper-adv">
    <div class="swiper-wrapper">
        <div class="swiper-slide cover" style="background-image: url( {{ url('/img/topm01.png') }} )">
            <div class="container caption">
                <img src="/img/ceslogo.png" class="ces-logo">
                <h3>Fifish P4 <br><span>{{ trans('menu.event_ces') }}</span></h3>
                <a href="javascript:void(0);" class="btn btn-white btn-play" data-toggle="modal" data-target="#video-box">
                    {{ trans('menu.watch') }} <small><i class="glyphicon glyphicon-play-circle"></i></small>
                </a>
            </div>
        </div>
        <div class="swiper-slide cover" style="background-image: url( {{ url('/img/topm02.png') }} )">
            <div class="container caption-right">
                <h3>Fifish P4 <br><span>{{ trans('menu.event_fair') }}</span></h3>
            </div>
        </div>
    </div>
    <!-- 如果需要分页器 -->
    <div class="swiper-pagination"></div>
</div>

<div class="container-fluid">    
    <div class="row">
        <div class="col-md-12 text-center block-products">
            <h2 class="block-title white">
                <span>{{ trans('menu.productshow') }}</span>
            </h2>
            
            <div class="swiper-container swiper-products">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="/img/m01.png" class="photo">
                    </div>
                    <div class="swiper-slide">
                        <img src="/img/m02.png" class="photo">
                    </div>
                    <div class="swiper-slide">
                        <img src="/img/m03.png" class="photo">
                    </div>
                    <div class="swiper-slide">
                        <img src="/img/m04.png" class="photo">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 text-center block-news">
            <h2 class="block-title">
                <span>{{ trans('menu.news') }}</span>
            </h2>
            <div class="swiper-container swiper-news">
                <div class="swiper-wrapper">
                    @foreach ($columns as $column)
                    <div class="swiper-slide">
                        <div class="thumbnail card">
                            <a href="{{ $column->url }}" class="image" target="_blank">
                                <img src="{{ $column->cover ? $column->cover->file->adpic : '/img/news/feng.png' }}" alt="{{ $column->title }}">
                            </a>
                            <div class="info">
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
            </div>
            
            <a href="{{ url('/news') }}" class="btn btn-blue btn-more">查看更多</a>   
            
            <div class="mideas mt-2r">
                <img src="/img/media/36kr.png" class="logo">
                <img src="/img/media/technode.png" class="logo">
                <img src="/img/media/geekpark.png" class="logo">
                <img src="/img/media/net163.png" class="logo">
                <img src="/img/media/sina.png" class="logo">
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 text-center block-about white">
            <h2 class="block-title white">
                <span>{{ trans('menu.aboutus') }}</span>
            </h2>
            <p>{{ trans('aboutme.info') }}</p>
            <p>{{ trans('aboutme.info2') }}</p>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 text-center block-contact">
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

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" id="video-box">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
                <span class="sr-only">Close</span>
            </button>
            <video id="fifish-v1" controls="controls" webkit-playsinline>
                <source src="http://oe5tkubcj.bkt.clouddn.com/Fifish_final_2000kbps_720p.mp4" type="video/mp4">
                    Your browser does not support the video tag.
            </video>
        </div>
    </div>
</div>

@endsection