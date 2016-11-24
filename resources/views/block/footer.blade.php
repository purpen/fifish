<div class="footer">
    <!--div class="container">
        <div class="row">
            <div class="col-lg-3">
                <h5>关于Fifish</h5>
                <div class="text-list">
                  <a href="{{ url('/aboutus') }}" class="item {{ $sub_menu_aboutus or '' }}">关于我们</a>
                  <a href="{{ url('/contact') }}" class="item {{ $sub_menu_contact or '' }}">联系我们</a>
                </div>
            </div>
            <div class="col-lg-3">
                <h5>媒体中心</h5>
                <div class="text-list">
                  <a href="" class="item">公司新闻</a>
                  <a href="" class="item">媒体报道</a>
                </div>
            </div>
            <div class="col-lg-3">
                <h5>帮助中心</h5>
                <div class="text-list">
                  <a href="" class="item">常见问题</a>
                  <a href="" class="item">售后问题</a>
                  <a href="" class="item">经销商</a>
                </div>
            </div>
            <div class="col-lg-3">
                <h5>关注我们</h5>
                <div class="socialbox">
                    <a class="social facebook" href="http://www.facebook.com/" target="_blank">
                        facebook
                    </a>
                    <a class="social instgram" href="{{ url('/') }}" target="_blank">
                        instgram
                    </a>
                    <a class="social weixin" href="{{ url('/') }}" target="_blank">
                        weixin
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="line"></div-->
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <p>
                    Copyright © 2016 Shenzhen QiYuan Technology Co. Ltd. 粤ICP备16095284号-1
                </p>
            </div>
            <div class="col-md-4 text-right">
                <label class="lang">语言：</label>
                <select class="lang-choose">
                    <option value="zh-CN" @if(App::getLocale() == 'zh-CN')selected="selected"@endif >CN中文</option>
                    <option value="en" @if(App::getLocale() == 'en')selected="selected"@endif >English</option>
                </select>
            </div>
        </div>
    </div>
</div>
