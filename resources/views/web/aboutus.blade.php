@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-8">
            <h5>关于FIFISH</h5>
        </div>
        <div class="col-lg-4 text-right">
            <h5 class="subnav">
                <a href="{{ url('/aboutus') }}" class="{{ $sub_menu_aboutus or '' }}">关于我们</a> 
                <a href="{{ url('/contact') }}" class="{{ $sub_menu_contact or '' }}">联系我们</a>
            </h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="banner">
              <h4 class="text-center">关于我们</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 text-center">     
            <div class="aboutus">       <p>深圳鳍源科技有限公司是一家专注于海洋探索的科技创新公司，通过互联网理念和现代科研力量构建全新的海洋商业模式，系列产品主推消费及轻工业市场。公司以研发销售水下机器人为硬件载体，搭载互联网内容平台，聚集来自世界各地的好奇者，开拓神秘未知的海底视野。</p>
                <p>
                未知、神秘、源源不断的好奇心，使人类对“海洋 ”始终保持着敬畏与渴望。我们深信让更多人依靠技术介质感受水下魅力，探索精神将更具普遍意义。
                </p>
            </div>
        </div>
    </div>
</div>
@endsection