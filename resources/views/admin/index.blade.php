@extends('layouts.admin')

@section('content')
<div class="content-header">
    <h1>
        概况
        <small>Current version 1.0.0</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="/admin">
                <i class="fa fa-dashboard"></i>
                控制台
            </a>
        </li>
        <li class="active">概况</li>
    </ol>
</div>

<div class="content body">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-blue"><i class="fa fa-user-plus"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">用户</span>
                    <span class="info-box-number">{{ $user_total }}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-green"><i class="fa fa-files-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">分享</span>
                    <span class="info-box-number">{{ $stuff_total }}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-red"><i class="fa fa-thumbs-o-up"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">点赞</span>
                    <span class="info-box-number">{{ $like_total }}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <!-- Apply any bg-* class to to the icon to color it -->
                <span class="info-box-icon bg-yellow"><i class="fa fa-comments-o"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">回复</span>
                    <span class="info-box-number">{{ $comment_total }}</span>
                </div><!-- /.info-box-content -->
            </div><!-- /.info-box -->
        </div>
    </div>
    
    
    
</div>
@endsection