@extends('layouts.app')

@section('partial_css')
<style type="text/css">
    .c-title {
        margin-bottom: 20px;
        margin-top: 30px;
        font-size: 1.2em;
    }
    .c-content {
        margin: 0 0 30px 40px;
    }
    .sub-title {
        font-weight: bold;
    }

    .line_m{
        text-decoration:line-through;
        color: #ccc;
    }

</style>
@endsection

@section('content')

<div class="banner banner-recruit">
    <h4 class="text-center block-title white">
        <span>{{ trans('menu.recruit') }}</span>
    </h4>
</div> 

<div class="container">   
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div>
                <div class="text-center c-title"><span class="line_m">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="sub-title">{{ trans('recruit.area_01') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="line_m">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                <div class="c-content">
                    <p><span class="sub-title">{{ trans('recruit.title_01') }}</span></p>
                    <p>{{ trans('recruit.content_01_01') }}</p>
                    <p>{{ trans('recruit.content_01_02') }}</p>
                    <p>{{ trans('recruit.content_01_03') }}</p>
                    <p>{{ trans('recruit.content_01_04') }}</p>
                </div>
                <div class="c-content">
                    <p><span class="sub-title">{{ trans('recruit.title_02') }}</span></p>
                    <p>{{ trans('recruit.content_02_01') }}</p>
                    <p>{{ trans('recruit.content_02_02') }}</p>
                    <p>{{ trans('recruit.content_02_03') }}</p>
                    <p>{{ trans('recruit.content_02_04') }}</p>
                </div>
                <div class="c-content">
                    <p><span class="sub-title">{{ trans('recruit.title_03') }}</span></p>
                    <p>{{ trans('recruit.content_03_01') }}</p>
                    <p>{{ trans('recruit.content_03_02') }}</p>
                    <p>{{ trans('recruit.content_03_03') }}</p>
                    <p>{{ trans('recruit.content_03_04') }}</p>
                </div>
                <div class="c-content">
                    <p><span class="sub-title">{{ trans('recruit.title_04') }}</span></p>
                    <p>{{ trans('recruit.content_04_01') }}</p>
                    <p>{{ trans('recruit.content_04_02') }}</p>
                    <p>{{ trans('recruit.content_04_03') }}</p>
                    <p>{{ trans('recruit.content_04_04') }}</p>
                </div>
            </div>

            <div>
                <div class="text-center c-title"><span class="line_m">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="sub-title">{{ trans('recruit.area_02') }}</span>&nbsp;&nbsp;&nbsp;&nbsp;<span class="line_m">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></div>
                <div class="c-content">
                    <p><span class="sub-title">{{ trans('recruit.title_05') }}</span></p>
                    <p>{{ trans('recruit.content_05_01') }}</p>
                    <p>{{ trans('recruit.content_05_02') }}</p>
                    <p>{{ trans('recruit.content_05_03') }}</p>
                    <p>{{ trans('recruit.content_05_04') }}</p>
                    <p>{{ trans('recruit.content_05_05') }}</p>
                </div>
                <div class="c-content">
                    <p><span class="sub-title">{{ trans('recruit.title_06') }}</span></p>
                    <p>{{ trans('recruit.content_06_01') }}</p>
                    <p>{{ trans('recruit.content_06_02') }}</p>
                    <p>{{ trans('recruit.content_06_03') }}</p>
                    <p>{{ trans('recruit.content_06_04') }}</p>
                </div>
                <div class="c-content">
                    <p><span class="sub-title">{{ trans('recruit.title_07') }}</span></p>
                    <p>{{ trans('recruit.content_07_01') }}</p>
                    <p>{{ trans('recruit.content_07_02') }}</p>
                    <p>{{ trans('recruit.content_07_03') }}</p>
                    <p>{{ trans('recruit.content_07_04') }}</p>
                </div>

            </div>

            <!--  
            <div class="aboutus">       
                <p>{{ trans('aboutme.info') }}</p>
                <p>
                    {{ trans('aboutme.info2') }}
                </p>
            </div>
            -->
        </div>
    </div>
</div>
@endsection
