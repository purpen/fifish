@extends('layouts.admin')

@section('content')
<div class="content-header">
    <h1>
        标签管理
    </h1>
    <ol class="breadcrumb">
        <li>
            <a href="/">
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
                    <div class="box-tools">
                        <a href="{{ url('/admin/tags/create') }}" class="btn btn-link">+新增</a>
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
                                            <th>名称</th>
                                            <th>数量</th>
                                            <th>状态</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tags as $tag)
                                        <tr>
                                            <td>
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" name="ids[]" value="{{ $tag->id }}" aria-label="...">
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $tag->name }} @if ($tag->display_name)[{{ $tag->display_name }}]@endif
                                            </td>
                                            <td>
                                                {{ $tag->total_count }}
                                            </td>
                                            <td>
                                                @if ($tag->sticked)
                                                    <span class="label label-success">推荐</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="/admin/tags/{{ $tag->id }}" method="POST">
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
                                    显示 {{ $tags->firstItem() }} 至 {{ $tags->lastItem() }} 条，共 {{ $tags->total() }} 条记录
                                </div>
                            </div>
                            <div class="col-sm-7">
                                <div id="datatable_paginate" class="dataTables_paginate paging_simple_numbers">
                                    {!! $tags->links() !!}
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

