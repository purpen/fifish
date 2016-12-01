@extends('layouts.admin')

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
    			{ title : "Image files", extensions : "jpg,gif,png,mp4" },
    			{ title : "Zip files", extensions : "zip" }
    		]
    	},
        flash_swf_url : '{{ asset('js/plupload/Moxie.swf') }}', //swf文件，当需要使用swf方式进行上传时需要配置该参数
        silverlight_xap_url : '{{ asset('js/plupload/Moxie.xap') }}' //silverlight文件，当需要使用silverlight方式进行上传时需要配置该参数
    });
    
    //在实例对象上调用init()方法进行初始化
    uploader.init();
    
    {{--//绑定各种事件，并在事件监听函数中做你想做的事--}}
    {{--uploader.bind('FilesAdded',function(uploader,files){--}}
        {{--//每个事件监听函数都会传入一些很有用的参数，--}}
        {{--//我们可以利用这些参数提供的信息来做比如更新UI，提示上传进度等操作--}}
    {{--});--}}
    {{--uploader.bind('UploadProgress',function(uploader,file){--}}
        {{--//每个事件监听函数都会传入一些很有用的参数，--}}
        {{--//我们可以利用这些参数提供的信息来做比如更新UI，提示上传进度等操作--}}
    {{--});--}}
    
    {{--//最后给"开始上传"按钮注册事件--}}
    {{--document.getElementById('start_upload').onclick = function(){--}}
        {{--uploader.start(); //调用实例对象的start()方法开始上传文件，当然你也可以在其他地方调用该方法--}}
    {{--}--}}
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


    //上传视频
    var videoUploader = new plupload.Uploader({　
        browse_button : 'video', //触发文件选择对话框的按钮，为那个元素id
        url : '{{ $upload_url }}', //服务器端的上传页面地址
        multipart: true,
        multipart_params: {
            token: "{{ $videoToken }}"
        },
        filters : {
        max_file_size : '1gb',
        mime_types: [
                { title : "Image files", extensions: "mpg,m4v,mp4,flv,3gp,mov,avi,rmvb,mkv,wmv" }
            ]
        },
        multi_selection: false,

    });
    //在实例对象上调用init()方法进行初始化
    videoUploader.init();

    // 绑定各种事件，并在事件监听函数中做你想做的事
    videoUploader.bind('FilesAdded',function(uploader, files){
        videoUploader.start();
    });

    videoUploader.bind('FileUploaded', function(videoUploader, file, result){

        var resultObj = eval('(' + result.response + ')');
        console.info(resultObj.file.small);

        $('#video_id').val(resultObj.id);
    });
@endsection

@section('content')
<div class="content-header">
    <h1>
        分享管理
        <small>全球用户分享</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="/admin">
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
                </div>
                <div class="box-body">
                    <form action="{{ url('/admin/stuffs') }}/{{ $stuff->id }}" method="post" id="imgForm" enctype="multipart/form-data" accept-charset="UTF-8" class="form-horizontal" role="form">
                        <input type="hidden" name="asset_id" id="asset_id" >
                        <input type="hidden" name=video_id" id="video_id" >
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        {{--<div class="form-group">--}}
                            {{--<label class="col-sm-2 control-label">选择照片</label>--}}
                            {{--<div class="col-sm-10">--}}
                                {{--<button id="browse">上传照片</button>--}}
                                {{----}}
                                {{--<a herf="javascript:void(0);" id="start_upload">开始上传</a>--}}
                            {{--</div>--}}
                        {{--</div>--}}
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
                            <label class="col-sm-2 control-label">选择视频</label>
                            <div class="col-sm-10">
                                <div id="video" class="btn btn-primary">上传视频</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="content" class="col-sm-2 control-label">分享内容</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" placeholder="分享内容" name="content">{{ $stuff->content }}</textarea>
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