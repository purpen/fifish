@extends('layouts.admin')

@section('jquery')
    
@endsection

@section('content')
<div class="content-header">
    <h1>
        栏目位置管理
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="/admin">
                <i class="fa fa-dashboard"></i>
                控制台
            </a>
        </li>
        <li class="active">栏目位置管理</li>
    </ol>
</div>

<div class="content body">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">新增位置</h3>
                    <div class="box-tools">
                        <a href="{{ url('/admin/columnspaces/create') }}" class="btn btn-default">新增</a>
                    </div>
                </div>
                <div class="box-body">
                    @include('block/errors')
                    <form action="{{ url('/admin/columnspaces') }}" method="post" id="addColumnSpace" enctype="multipart/form-data" class="form-horizontal" role="form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">标识*</label>
                            <div class="col-sm-4">
                                <input type="text" name="name" class="form-control" value="{{old('name')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="type" class="col-sm-2 control-label">类型*</label>
                            <div class="col-sm-4">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="type" value="1" checked> 官网
                                    </label>
                                    <label>
                                        <input type="radio" name="type" value="2"> APP
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="summary" class="col-sm-2 control-label">说明</label>
                            <div class="col-sm-10">
                                <input type="text" name="summary" class="form-control" value="{{old('summary')}}">
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
@section('customize_js')
    @parent
    $('#addColumnSpace').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: '标识不能为空！'
                    }
                }
            },
            type: {
                validators: {
                    notEmpty: {
                        message: '请选择类型！'
                    }
                }
            }
        }
    });
@endsection