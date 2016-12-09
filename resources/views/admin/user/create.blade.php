@extends('layouts.admin')

@section('customize_css')
#uploader-result {
    padding: 20px 0 5px;
}
#uploader-result .asset {
    display: inline-block;
    width: 120px;
}
@endsection

@section('jquery')
    // 实例化一个plupload上传对象    
    var uploader = new plupload.Uploader({
        browse_button : 'uploader', //触发文件选择对话框的按钮，为那个元素id
        url : '{{ $upload_url }}', //服务器端的上传页面地址
        multipart: true,
        multipart_params: { 
            token: "{{ $token }}" 
        },
        multi_selection: false,
    	filters : {
    		max_file_size : '10mb',
    		mime_types: [
    			{ title : "Image files", extensions : "jpg,gif,png" }
    		],
            prevent_duplicates : true //不允许选取重复文件
    	},
        flash_swf_url : '{{ asset('js/plupload/Moxie.swf') }}', //swf文件，当需要使用swf方式进行上传时需要配置该参数
        silverlight_xap_url : '{{ asset('js/plupload/Moxie.xap') }}',
    });
    
    // 在实例对象上调用init()方法进行初始化
    uploader.init();
    
    // 绑定各种事件，并在事件监听函数中做你想做的事
    uploader.bind('FilesAdded',function(uploader, files){
        uploader.start();
    });
    
    uploader.bind('FileUploaded', function(uploader, file, result){
        
        var resultObj = eval('(' + result.response + ')');
        console.info(resultObj.file.small);
        
        $('#uploader-result').html('<div class="asset"><img src="'+resultObj.file.small+'"></div>');
        $('#asset_id').val(resultObj.id);
    });
    
@endsection

@section('content')
<div class="content-header">
    <h1>
        用户管理
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="/admin">
                <i class="fa fa-dashboard"></i>
                控制台
            </a>
        </li>
        <li class="active">用户管理</li>
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
                @include('block.errors')
                    <form action="{{ url('/admin/users') }}" method="post" id="addUser" class="form-horizontal" role="form">                             {{ csrf_field() }}
                        <input type="hidden" name="asset_id" id="asset_id" >
                        <div class="form-group">
                            <label for="account" class="col-sm-2 control-label">账号(E-Mail)*</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="account" value="{{old('account')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="username" class="col-sm-2 control-label">用户昵称*</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="username" value="{{old('username')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">邮箱*</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="email" value="{{old('email')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-sm-2 control-label">手机号*</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="phone" value="{{old('phone')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">选择图片</label>
                            <div class="col-sm-10">
                                <div id="uploader" class="btn btn-success">
                                    上传头像
                                </div>
                                
                                <div id="uploader-result"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="sex">性别</label>
                            <div class="col-sm-10">
                                <div class="radio-inline">
                                    <label class="col-xs-5">
                                        <input name="sex" value="0" type="radio" id="sex0" checked> 保密
                                    </label>
                                    <label class="col-xs-4">
                                        <input name="sex" value="1" type="radio" id="sex1"> 男
                                    </label>
                                    <label class="col-xs-3">
                                        <input name="sex" value="2" type="radio" id="sex2"> 女
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="summary" class="col-sm-2 control-label">个性签名</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="summary" value="{{old('summary')}}"></textarea>
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
    $('#addUser').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            account: {
                validators: {
                    notEmpty: {
                        message: '账号(E-Mail)不能为空！'
                    },
                    regexp: {
                        regexp: /^([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/gi,
                        message: '格式不正确！'
                    }
                }
            },
            username: {
                validators: {
                    notEmpty: {
                        message: '用户昵称不能为空！'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: '邮箱不能为空！'
                    },
                    regexp: {
                        regexp: /^([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\-|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/gi,
                        message: '格式不正确！'
                    }
                }
            },
            phone: {
                validators: {
                    notEmpty: {
                        message: '手机号不能为空！'
                    },
                    regexp: {
                        regexp: /^1[34578][0-9]{9}$/,
                        message: '格式不正确！'
                    }
                }
            }
        }
    });
@endsection

