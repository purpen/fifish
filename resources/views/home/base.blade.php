@extends('layout.app')

@section('header')
    @parent
    @include('block.header')
@endsection

@section('content')
    @parent
    
@endsection

@section('footer')
    @parent
    @include('block.footer')
@endsection
