@extends('layouts.app')

@section('jquery')
	$('#uploader').fineUploader({
      	request: {
			inputName:'file',
			params:{'token': '{{ $token }}' },
        	endpoint:'{{ $upload_url }}',
      	},
		text: {
            uploadButton: '<a class="ui active orange labeled icon button" href="javascript:void(0);"><i class="cloud upload icon"></i>选择图片</a>'
		},
		template: '<div class="qq-uploader">' +
					'<pre class="qq-upload-drop-area"><span>{dragZoneText}</span></pre>' +
					'<div class="qq-upload-button">{uploadButtonText}</div>' +
					'<span class="qq-drop-processing"><span>{dropProcessingText}</span><span class="qq-drop-processing-spinner"></span></span>' +
					'<ul class="qq-upload-list clearfix" style="margin-top: 5px; text-align: center;"></ul>' +
					'</div>',
		validation: {
	        allowedExtensions: ['jpeg', 'jpg', 'png', 'gif'],
	        sizeLimit: 5245728 // 5M = 5 * 1024 * 1024 bytes
	    }
    }).on('complete', function (event, id, name, result) {
		
	});
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            
            <div class="upload-mask">
            </div>
            <div class="panel panel-info upload-file">
                <div class="panel-heading">
                    上传图片
                    <span class="close pull-right">关闭</span>
                </div>
                <div class="panel-body">
                    <div id="validation-errors"></div>
                    <form action="{{ $upload_url }}" method="post" id="imgForm" enctype="multipart/form-data" accept-charset="UTF-8">
                    <div class="form-group">
                        <label>图片上传</label>
                        <div id="uploader"></div>
                        <input name="token" type="hidden"  value="{{ $token }}">
                        <input type="submit" name="submit" value="开始上传">

                    </div>
                    </form>
                    
                    
                </div>
                <div class="panel-footer">
                </div>
            </div>
            
            
            
            
        </div>
    </div>
</div>
@endsection