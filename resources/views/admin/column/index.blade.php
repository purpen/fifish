@extends('layouts.admin')

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
                    <h3 class="box-title">全部列表</h3>
                    <div class="box-tools">
                        <a href="{{ url('/admin/columns/create') }}" class="btn btn-link">+新增</a>
                    </div>
                </div>
                <div class="box-body">
                    <div id="datatable_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="dataTables_length">
                                    <label>
                                        
                                        <select class="form-control select2 input-sm" name="per_page">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select>
                                        条/页
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="dataTables_filter">
                                    <!--filter-->
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input class="form-control pull-right" type="text" placeholder="搜索" name="table_search">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default" type="submit">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-striped dataTable" role="grid">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>照片</th>
                                            <th>标题</th>
                                            <th class="sorting_asc">发布时间</th>
                                            <th>状态</th>
                                            <th>所属位置</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($columns as $column)
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="ids[]" value="{{ $column->id }}" aria-label="...">
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <img src="{{ $column->cover ? $column->cover->file->small : '' }}" width="90px" >
                                            </td>
                                            <td>{{ $column->title }}</td>
                                            <td>{{ $column->created_at }}</td>
                                            <td>
                                                {{ $column->status_label }}
                                            </td>
                                            <td>{{ $column->column_space->summary }}</td>
                                            <td>
                                                <form action="/admin/columns/{{ $column->id }}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <a href="/admin/columns/{{ $column->id }}/edit" class="btn btn-sm btn-default">编辑</a>
                                                    <button class="btn btn-sm bg-orange">
                                                        <span class="fa fa-trash" aria-hidden="true"></span> 删除
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-5">
                                <div id="datatable_info" class="dataTables_info" role="status" aria-live="polite">
                                    显示 {{ $columns->firstItem() }} 至 {{ $columns->lastItem() }} 条，共 {{ $columns->total() }} 条记录
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div id="datatable_paginate" class="dataTables_paginate paging_simple_numbers">
                                    {!! $columns->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

