@extends('layouts.admin')

@section('content')
<div class="content-header">
    <h1>
        附件管理
        <small>照片、视频</small>
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="/admin">
                <i class="fa fa-dashboard"></i>
                控制台
            </a>
        </li>
        <li class="active">附件管理</li>
    </ol>
</div>

<div class="content body">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">全部列表</h3>
                    <div class="box-tools">
                        
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
                                            <th>文件名称</th>
                                            <th class="sorting_asc">上传时间</th>
                                            <th>大小</th>
                                            <th>所属对象</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($assets as $asset)
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="ids[]" value="{{ $asset->id }}" aria-label="...">
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                <img src="{{ $asset->fileurl ? $asset->fileurl : '' }}" width="90px" >
                                            </td>
                                            <td>{{ $asset->filename }}</td>
                                            <td>{{ $asset->created_at }}</td>
                                            <td>
                                                {{ $asset->size }}
                                            </td>
                                            <td></td>
                                            <td>
                                                <form action="/admin/stuffs/{{ $asset->id }}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}

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
                                    显示 {{ $assets->firstItem() }} 至 {{ $assets->lastItem() }} 条，共 {{ $assets->total() }} 条记录
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div id="datatable_paginate" class="dataTables_paginate paging_simple_numbers">
                                    {!! $assets->links() !!}
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

