@extends('layouts.admin')

@section('content')
<div class="content-header">
    <h1>
        标签管理
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="/">
                <i class="fa fa-dashboard"></i>
                控制台
            </a>
        </li>
        <li class="active">标签管理</li>
    </ol>
</div>

<div class="content body">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">全部列表</h3>
                </div>
                <div class="box-body">
                    <form action="/admin/tags" method="post" id="imgForm" class="form-horizontal" role="form">                          {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">标签名称</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="name"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="display_name" class="col-sm-2 control-label">显示名称</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="display_name"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">标签说明</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="description"></textarea>
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

