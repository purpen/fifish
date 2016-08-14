@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li class="active">
                    <a href="/admin">概述 <span class="sr-only">(current)</span></a>
                </li>
                <li><a href="/admin/stuffs">分享管理</a></li>
                <li><a href="/admin/tags">标签管理</a></li>
                <li><a href="/admin/assets">附件管理</a></li>
                
                <li><a href="/admin/users">用户管理</a></li>
                <li><a href="/admin/">数据统计</a></li>
            </ul>
        </div>
        <div class="col-md-10 main">
            @yield('mainbar')
        </div>
    </div>
<div>
@endsection