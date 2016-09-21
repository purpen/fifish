@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="/img/story_home.jpg">
                        
                        <div class="carousel-caption">
                            <h3>FIFISH P4</h3>
                            <p>亮相2016布尔诺国际机械<br>工业博览会</p>
                        </div>
                    </div>
                </div>

                <!-- Controls -->
                <!--
                <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
                -->
            </div>
            
        </div>
    </div>
</div>

<div class="container focus">
    <div class="row">
        <div class="col-lg-4">
            <div class="focus-item tutorials">
                <h4>新手教程</h4>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="focus-item video">
                <h4>视频集锦</h4>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="focus-item event">
                <h4>精彩活动</h4>
            </div>
        </div>
    </div>
</div>
@endsection
