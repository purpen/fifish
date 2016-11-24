@extends('layouts.wap')

@section('content')
<div class="container-fluid container-wap-news">
    
    <div class="row text-center">
        @foreach ($columns as $column)
        <div class="thumbnail card">
            <a href="{{ $column->url }}" class="image" target="_blank">
                <img src="{{ $column->cover ? $column->cover->file->adpic : '' }}" alt="{{ $column->title }}">
            </a>
            <div class="info">
                <h3>
                    <a href="{{ $column->url }}" target="_blank">{{ $column->title }}</a>
                </h3>
                <p>
                    <span class="text-blue">{{ $column->sub_title }}</span>
                    <span class="pull-right text-time">{{ $column->summary }}</span>
                </p>
          </div>
        </div>
        @endforeach
    </div>
    
</div>
@endsection