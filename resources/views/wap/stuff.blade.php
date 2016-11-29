@extends('layouts.h5')

@section('customize_css')
    .vh5 {
        margin-top: 10px;
    }
    .vh5 h4 {
        font-weight: 300;
        padding-left: 10px;
    }
    .user {
        margin: 10px auto;
        padding-left: 10px;
    }
    .user .avatar {
        border-radius: 100px;
        width: 50px;
        height: 50px;
    }
    .user .media-heading {
        padding-left: 0px;
    }
    
    .box .image {
        position: relative;
    }
    .box .image img,
    .box .image video {
        width: 100%;
    }
    .box .content {
        margin-top: 10px;
        font-weight: 300;
        padding-left: 10px;
    }
    .box .content .tag {
        font-weight: 300;
    }
    .stuff-list {
        margin: 10px auto;
    }
    .stuff-list .stuff {
        padding: 2px 1px 0 1px;
    }
    .stuff-list .stuff img {
        width: 100%;
    }
@endsection

@section('content')
<div class="container-fluid vh5">
    <div class="row">
        <div class="col-sm-12">
            
            <div class="media user">
                <a class="media-left" href="{{ url('/user') }}/{{ $stuff->user->id }}">
                    <img src="{{ $stuff->user->avatar->small }}" alt="{{ $stuff->user->username }}" class="avatar">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">{{ $stuff->user->username }}</h4>
                    <small class="text-muted">{{ $stuff->created_at }}</small>
                </div>
            </div>
            
            <div class="box">
                <div class="image">
                    @if ($stuff->kind == 2)
                    <video id="FiVideo" controls="" preload="auto" autoplay="autoplay" src="{{ $stuff->cover ? $stuff->cover->file->srcfile : '' }}" poster="{{ $stuff->cover ? $stuff->cover->file->large : '' }}">
                    </video>
                    @else
                    <img src="{{ $stuff->cover ? $stuff->cover->file->large : '' }}" alt="{{ $stuff->title }}">
                    @endif
                </div>
                <div class="content">
                    <!--显示标签-->
                    @foreach ($stuff->tags as $tag)
                        <label class="tag">#{{ $tag->name }}</label> 
                    @endforeach
                    
                    {{ $stuff->content }}
                </div>
            </div>
        </div>
    </div>
    <div class="row stuff-list">   
        <h4>大家都在玩</h4>
          
    </div>
</div>
@endsection