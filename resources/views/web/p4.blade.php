@extends('layouts.app')

@section('partial_css')
<style type="text/css">
.p4-main {
  width: 100%;
  background-color: #000;
  margin: 0 auto;
  text-align: center;
  color: #fff;
}

.blank20 {
  margin: 20px;
}
.blank40 {
  margin: 40px;
}
.blank60 {
  margin: 60px;
}

.w1180 {
  width: 1180px;
  margin: 0 auto;
}
.w700 {
  width: 700px;
  margin: 0 auto;
}
.w1000 {
  width: 1000px;
  margin: 0 auto;
}

p.title {
  letter-spacing: 3px;
  font-size: 5rem;
}
p.sub-title {
  letter-spacing: 2px;
  font-size: 1.5rem;
  line-height: 2;
  margin: 20px auto;
  padding: 0 20px;
  text-align: center;
}

.p-title {
  width: 100%;
  height: 80px;
  background: url( {{ url('/img/p4/icon/logo.png') }} ) no-repeat center;
}

.p4-01 {
}
.p4-01 .ld {
  width: 850px;
  height: 200px;
  margin: -50px auto 0 auto;
  padding-left: 60px;
}
.p4-01 .ld .item {
  float: left;
}
.p4-01 .ld .item p {
  padding: 20px;
  margin: 0 50px 0 50px;
  font-size: 2rem;
}

.p4-02 {
  width: 100%;
  height: 950px;
  background: url( {{ url('/img/p4/lens2.png') }} ) no-repeat left bottom;
}

.wangy {
  width: 1180px;
  height: 1050px;
  background: url( {{ url('/img/p4/wang.png') }} ) no-repeat bottom;
  position: relative;
  margin: 0 auto;
}

.wangy img.i-1 {
  position: absolute;
  bottom: 0;
  left: 0;
}
.wangy img.i-2 {
  position: absolute;
  top: 77%;
  left: 22%;
  z-index: 5;
}
.wangy img.i-3 {
  position: absolute;
  bottom: 0;
  right: 0;
}

.p4-04 {
  margin-top: 200px;
}

.p4-06 {
  height: 1250px;
  background: url( {{ url('/img/p4/shishi1.png') }} ) no-repeat center bottom;
  position: relative;
  margin: 0 auto;
  text-align: left;
}
.p4-06-text {
  width: 1180px;
  margin: 0 auto;
}

.p4-07 {
  height: 1060px;
  background: url( {{ url('/img/p4/bg5_1.png') }} ) no-repeat center top;
  position: relative;
  margin: 0 auto;
}

.p4-07 .tx {
  width: 1180px;
  margin: 50px auto 0 auto;
}

.p4-07 .tx .item {
  float: left;
  margin: 20px 70px 20px 70px;
}
.p4-07 .tx .item p {
  font-size: 2rem;
  padding-top: 20px;
}

.p4-08 {
  margin: 0 auto;
  clear: both;
}
.albums {
  height: 500px;
  margin-top: 40px;
  text-align: center;
}
.albums img {
  float: left;
  margin: 0 0.5%;
  width: 24%;
}


</style>
@endsection

@section('content')
    
<!--
<div class="banner">
    <h4 class="text-center block-title white">
        <span>{{ trans('menu.aboutus') }}</span>
    </h4>
</div> 
-->

<div class="p4-main">
  <div class="p-title"></div>

  <div class="p4-01">
    <p class="title">{{ trans('p4.title_01') }}</p>
    <div class="blank60"></div>
    <img src="{{ url('/img/p4/01.png') }}" />
    <div class="ld">
      <div class="item">
        <img src="{{ url('/img/p4/icon/sx_01.png') }}" width="50" />
        <p>{{ trans('p4.title_01_01') }}</p>
      </div>
      <div class="item">
        <img src="{{ url('/img/p4/icon/sx_02.png') }}" width="50" />
        <p>{{ trans('p4.title_01_02') }}</p>
      </div>
      <div class="item">
        <img src="{{ url('/img/p4/icon/sx_03.png') }}" width="50" />
        <p>{{ trans('p4.title_01_03') }}</p>
      </div>
    </div>
  </div>

  <div class="p4-02">
    <p class="title">{{ trans('p4.title_02') }}</p>
    <p class="title">{{ trans('p4.title_02_p') }}</p>
    <p class="sub-title w1180">{{ trans('p4.title_02_01') }}</p>
  </div>
  <div class="blank60"></div>

  <div class="p4-03">
    <p class="title">{{ trans('p4.title_03') }}</p>
    <p class="sub-title w700">{{ trans('p4.title_03_01') }}</p>
    <div class="blank60"></div>
    <div class="wangy">
      <img src="{{ url('/img/p4/light.png') }}" />

      <img class="i-1" src="{{ url('/img/p4/light3-1.png') }}" />
      <img class="i-2" src="{{ url('/img/p4/light3-2.png') }}" />
      <img class="i-3" src="{{ url('/img/p4/light3-3.png') }}" />
    </div>
  </div>

  <div class="blank60"></div>

  <div class="p4-04">
    <p class="title">{{ trans('p4.title_04') }}</p>
    <p class="title">{{ trans('p4.title_04_p') }}</p>
    <p class="sub-title w1000">{{ trans('p4.title_04_01') }}</p>
    <div class="blank40"></div>
    <img src="{{ url('/img/p4/eight.png') }}" />
  </div>

  <div class="p4-05">
    <p class="title">{{ trans('p4.title_05') }}</p>
    <p class="title">{{ trans('p4.title_05_p') }}</p>
    <p class="sub-title w1000">{{ trans('p4.title_05_01') }}</p>
    <div class="blank40"></div>
    <img src="{{ url('/img/p4/RC-1.png') }}" />
    <div class="blank40"></div>
  </div>

  <div class="p4-06">
    <div class="p4-06-text">
      <p class="title">{{ trans('p4.title_06') }}</p>
      <p class="title">{{ trans('p4.title_06_p') }}</p>
      <p class="sub-title w700" style="text-align: left;margin-left:0px;padding-left:0;margin-top:50px;">{{ trans('p4.title_06_01') }}</p>
      <img src="{{ url('/img/p4/icon/shishi_text.png') }}" width="900" style="margin: 300px 0 0 0px;" />
    </div>
  </div>

  <div class="p4-07">
    <img src="{{ url('/img/p4/icon/ces_logo.png') }}" width="250" style="margin-top:50px;" />
    <div class="blank40"></div>
    <p class="title">{{ trans('p4.title_07') }}</p>
    <p class="sub-title w700" style="font-size: 2.2rem;">{{ trans('p4.title_07_01') }}</p>

    <div class="tx">
      <div class="item">
        <img src="{{ url('/img/p4/icon/01.png') }}" width="50" />
        <p>{{ trans('p4.title_07_tx_01') }}</p>
      </div>
      <div class="item">
        <img src="{{ url('/img/p4/icon/02.png') }}" width="50" />
        <p>{{ trans('p4.title_07_tx_02') }}</p>
      </div>
      <div class="item">
        <img src="{{ url('/img/p4/icon/03.png') }}" width="50" />
        <p>{{ trans('p4.title_07_tx_03') }}</p>
      </div>
      <div class="item">
        <img src="{{ url('/img/p4/icon/04.png') }}" width="50" />
        <p>{{ trans('p4.title_07_tx_04') }}</p>
      </div>
      <div class="item">
        <img src="{{ url('/img/p4/icon/05.png') }}" width="50" />
        <p>{{ trans('p4.title_07_tx_05') }}</p>
      </div>

    </div>

    <div class="tx" style="clear:both;">
      <div class="item">
        <img src="{{ url('/img/p4/icon/06.png') }}" width="50" />
        <p>{{ trans('p4.title_07_tx_06') }}</p>
      </div>
      <div class="item">
        <img src="{{ url('/img/p4/icon/07.png') }}" width="50" />
        <p>{{ trans('p4.title_07_tx_07') }}</p>
      </div>
      <div class="item">
        <img src="{{ url('/img/p4/icon/08.png') }}" width="50" />
        <p>{{ trans('p4.title_07_tx_08') }}</p>
      </div>
      <div class="item">
        <img src="{{ url('/img/p4/icon/09.png') }}" width="50" />
        <p>{{ trans('p4.title_07_tx_09') }}</p>
      </div>
      <div class="item">
        <img src="{{ url('/img/p4/icon/10.png') }}" width="50" />
        <p>{{ trans('p4.title_07_tx_10') }}</p>
      </div>
    </div>

  </div>

  <div class="p4-08">
    <p class="title">{{ trans('p4.title_08') }}</p>
    <div class="albums">
      <img src="{{ url('/img/p4/1G9A5623.png') }}" />
      <img src="{{ url('/img/p4/1G9A5708.png') }}" />
      <img src="{{ url('/img/p4/1G9A5847.png') }}" />
      <img src="{{ url('/img/p4/1G9A5982.png') }}" />
    </div>
  </div>


</div>

@endsection
