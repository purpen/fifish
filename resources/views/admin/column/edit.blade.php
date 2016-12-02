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
    //实例化一个plupload上传对象    
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
        $('#cover_id').val(resultObj.id);
    });
    
@endsection

@section('content')
<div class="content-header">
    <h1>
        栏目管理
        <small>照片、视频</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="/admin">
                <i class="fa fa-dashboard"></i>
                控制台
            </a>
        </li>
        <li class="active">栏目推荐管理</li>
    </ol>
</div>

<div class="content body">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">编辑栏目</h3>
                </div>
                <div class="box-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form action="{{ url('/admin/columns') }}/{{ $column->id }}" method="post" id="imgForm" class="form-horizontal" role="form">
                        {{ csrf_field() }}     
                        <input type="hidden" name="cover_id" id="cover_id" >
                        {{ method_field('PUT') }}
                        <div class="form-group">
                            <label for="column_space_id" class="col-sm-2 control-label">所属位置*</label>
                            <div class="col-sm-4">
                                <select name="column_space_id" class="form-control select2">
                                    @foreach ($spaces as $space)
                                        @if ($space->id == $column->column_space_id)
                                        <option value="{{ $space->id }}" selected>{{ $space->summary }}</option>
                                        @else
                                        <option value="{{ $space->id }}">{{ $space->summary }}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">标题*</label>
                            <div class="col-sm-10">
                                <input type="text" name="title" class="form-control" value="{{ $column->title }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="sub_title" class="col-sm-2 control-label">副标题</label>
                            <div class="col-sm-10">
                                <input type="text" name="sub_title" class="form-control" value="{{ $column->sub_title }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="url" class="col-sm-2 control-label">目标链接*</label>
                            <div class="col-sm-10">
                                <input type="text" name="url" class="form-control" value="{{ $column->url }}">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-2 control-label">选择图片*</label>
                            <div class="col-sm-10">
                                <div id="uploader" class="btn btn-success">
                                    上传图片
                                </div>
                                
                                <div id="uploader-result">
                                    @if ($column->cover)
                                    <div class="asset">
                                        <img src="{{ $column->cover->file->small }}">
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="summary" class="col-sm-2 control-label">栏目说明</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" name="summary" value="{{  $column->summary }}">{!! $column->summary !!}</textarea>
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