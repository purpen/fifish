@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h2>
                API文档
            </h2>
        </section>

        <iframe src="/api/index.html" frameBorder=0 width="100%" height="1000px"></iframe>

    </div>
@endsection
