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
        标签管理
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="/admin">
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
                    @include('block/errors')
                    <form action="{{ url('/admin/tags') }}" method="post" id="addTag" class="form-horizontal" role="form">                             {{ csrf_field() }}
                        <input type="hidden" name="asset_id" id="asset_id" >
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">标签名称*</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="name" value="{{old('name')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="display_name" class="col-sm-2 control-label">显示名称*</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="display_name" value="{{old('display_name')}}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">选择图片*</label>
                            <div class="col-sm-10">
                                <div id="uploader" class="btn btn-success">
                                    上传图片
                                </div>
                                
                                <div id="uploader-result"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="same_words" class="col-sm-2 control-label">相关标签</label>
                            <div class="col-sm-10">
                                <input class="form-control" name="same_words" value="{{old('same_words')}}">
                                <span class="descirption">标签之间使用,隔开</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-sm-2 control-label">标签说明</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="description"  value="{{old('description')}}"></textarea>
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
    $('#addTag').formValidation({
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
                        message: '标签名称不能为空！'
                    },
                    stringLength: {
                        min: 2,
                        max: 15,
                        message: '标签名称必须由2-15位组成！'
                    }
                }
            },
            display_name: {
                validators: {
                    notEmpty: {
                        message: '显示名称不能为空！'
                    }
                }
            }
        }
    });
@endsection
