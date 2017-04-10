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
                <div class="caption">
                    <h3>
                        <a href="{{ $column->url }}" target="_blank">{{ str_limit($column->title, 56) }}</a>
                    </h3>
                    <p>
                        <span class="text-blue">{{ $column->sub_title }}</span>
                        <span class="pull-right">{{ $column->created_at }}</span>
                    </p>
              </div>
            </div>
        </div>
        @endforeach
    </div>
    
</div>
@endsection
