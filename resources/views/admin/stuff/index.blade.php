@extends('layouts.admin')

@section('content')
<div class="page-header">
    <h4>分享管理 <small>帮助?</small></h4>
</div>
<div class="page-tools">
    <div class="btn-group" role="group" aria-label="...">
        <button type="button" class="btn btn-default">删除</button>
        <button type="button" class="btn btn-default">下架</button>

        <div class="btn-group" role="group">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                管理操作
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#">批量删除</a></li>
                <li><a href="#">通过审核</a></li>
            </ul>
        </div>
    </div>
</div>

<table class="table table-bordered table-striped table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>照片</th>
            <th>发布者</th>
            <th>发布时间</th>
            <th>操作</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($stuffs as $stuff)
        <tr>
            <td>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="ids[]" value="{{ $stuff->id }}" aria-label="...">
                    </label>
                </div>
            </td>
            <td>
                <img src="{{ $stuff->cover ? $stuff->cover->fileurl : '' }}" width="90px" >
            </td>
            <td>{{ $stuff->user->username }}</td>
            <td>{{ $stuff->created_at }}</td>
            <td>
                <form action="/admin/stuff/{{ $stuff->id }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}

                    <button class="btn btn-sm btn-danger">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span> 删除
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<nav aria-label="Page navigation">
    {!! $stuffs->links() !!}
</nav>
@endsection