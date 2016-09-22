@extends('layouts.admin')

@section('content')
<div class="content-header">
    <h1>
        分享管理
        <small>全球用户分享</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="/">
                <i class="fa fa-dashboard"></i>
                控制台
            </a>
        </li>
        <li class="active">分享管理</li>
    </ol>
</div>

<div class="content body">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">全部列表</h3>
                    <div class="box-tools">
                        <a href="{{ url('/admin/stuffs/create') }}" class="btn btn-link">+新增</a>
                    </div>
                </div>
                <div class="box-body">
                    <form action="{{ $upload_url }}" method="post" id="imgForm" enctype="multipart/form-data" accept-charset="UTF-8" class="form-horizontal" role="form">
                        <input name="x:domain" type="hidden"  value="{{ $domain }}">
                        <input name="token" type="hidden"  value="{{ $token }}">
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">上传照片</label>
                            <div class="col-sm-10">
                                <input name="file" type="file"  required="required">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-sm-2 control-label">分享内容</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" placeholder="分享内容"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-default">确认提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection