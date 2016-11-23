@extends('layouts.app')

@section('content')
<div class="container container-news">
    
    <div class="row text-center">
        @foreach ($columns as $column)
        <div class="col-md-4">
            <div class="thumbnail card">
                <a href="{{ $column->url }}" class="image" target="_blank">
                    <img src="{{ $column->cover ? $column->cover->file->adpic : '' }}" alt="{{ $column->title }}">
                </a>
                <div class="info">
                    <h3>
                        <a href="" target="_blank">{{ $column->title }}</a>
                    </h3>
                    <p>
                        <span class="text-blue">{{ $column->sub_title }}</span>
                        <span class="pull-right text-time">{{ $column->summary }}</span>
                    </p>
              </div>
            </div>
        </div>
        @endforeach
    </div>
    
</div>
@endsection