@extends('layouts.app')


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
                        <span class="require">(*)</span>
                        <input name="file" type="file"  required="required">
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