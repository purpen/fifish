<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// 限定域名访问
Route::group(array('domain' => env('APP_DOMAIN')), function(){
    Route::get('/', 'HomeController@index');

    Route::auth();

    Route::get('/home', 'HomeController@index');

    Route::get('/job', 'HomeController@job');
    
    Route::post('/promo', 'HomeController@promo');

    Route::get('/avatar', 'HomeController@avatar');

    /**
     * 测试
     */
    Route::get('/test/search', 'TestController@search');
    Route::get('/test/del_search', 'TestController@delSearch');

    /**
     * 静态文件
     */
    Route::get('/aboutus', 'WebController@aboutUs');
    Route::get('/contact', 'WebController@contact');

    /**
     * 后台管理的路由组
     */
    Route::group(['middleware' => ['auth'], 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
    
        Route::get('/', 'OverviewController@index');
    
        Route::resource('stuffs', 'StuffController');
        Route::resource('columns', 'ColumnController');
        Route::resource('comments', 'TagController');
        Route::resource('assets', 'AssetController');
        Route::resource('users', 'UserController');
        Route::resource('tags', 'TagController');
        Route::resource('columnspaces', 'ColumnSpaceController');
        
        Route::resource('tags/{id}/stick', 'TagController@stick');
        Route::resource('tags/{id}/unstick', 'TagController@unstick');
    });
});

/**
 * 注册自定义
 */
app('Dingo\Api\Exception\Handler')->register(function (Exception $exception) {
    $request = Illuminate\Http\Request::capture();
    return app('App\Exceptions\Handler')->render($request, $exception);
});

/**
 * Api 路由
 */
$api = app('Dingo\Api\Routing\Router');

// V1版本，公有接口
$api->version('v1', ['namespace' => 'App\Http\Controllers\Api\V1'], function ($api) {
    
    // 用户注册
    $api->post('auth/register', [
        'as' => 'auth.register', 'uses' => 'AuthenticateController@register'
    ]);
    // 用户登录验证并返回Token
    $api->post('auth/login', [
        'as' => 'auth.login', 'uses' => 'AuthenticateController@login'
    ]);
    $api->post('auth/authenticate', [
        'as' => 'auth.authenticate', 'uses' => 'AuthenticateController@authenticate'
    ]);
    
    // 七牛上传回调
    $api->post('upload/qiniuback', [
        'as' => 'upload.qiniuback', 'uses' => 'UploadController@qiniuback'
    ]);
    // 七牛上传异步通知
    $api->post('upload/qiniuNotify', [
        'as' => 'upload.qiniuNotify', 'uses' => 'UploadController@qiniuNotify'
    ]);
    
    /**
     * 分享相关路由
     */    
    $api->get('stuffs', [
        'as' => 'stuffs', 'uses' => 'StuffController@getList'
    ]);
    $api->get('stuffs/sticklist', [
        'as' => 'stuffs.sticklist', 'uses' => 'StuffController@stickList'
    ]);
    $api->get('stuffs/featurelist', [
        'as' => 'stuffs.featurelist', 'uses' => 'StuffController@featureList'
    ]);
    $api->get('stuffs/{id}', [
        'as' => 'stuffs.show', 'uses' => 'StuffController@show'
    ])->where(['id' => '[0-9]+']);
    
    
    /**
     * 分享相关路由
     */    
    $api->get('stuffs/{id}/comments', [
        'as' => 'stuffs.comments', 'uses' => 'StuffController@comments'
    ]);
    
    /**
     * 点赞相关
     */
    $api->get('stuffs/{id}/likes', [
        'as' => 'stuffs.likes', 'uses' => 'StuffController@likes'
    ]);
    
    /**
     * 标签相关
     */
    $api->get('tags', [
        'as' => 'tags.list', 'uses' => 'TagController@getList'
    ]);
    $api->get('tags/sticks', [
        'as' => 'tags.stick', 'uses' => 'TagController@stickList'
    ]);
    $api->get('tags/{name}', [
        'as' => 'tags.show', 'uses' => 'TagController@show'
    ]);
    
    // 反馈意见列表
    $api->get('feedback/{state?}', [
        'as' => 'feedback.getlist', 'uses' => 'FeedbackController@getList'
    ])->where(['state' => '[0-9]+']);
    
    // 获取个人信息
    $api->get('user/{id}', [
        'as' => 'user', 'uses' => 'UserController@index'
    ])->where(['id' => '[0-9]+']);
    
    // 用户粉丝
    $api->get('user/{id}/fans', [
        'as' => 'user.fans', 'uses' => 'UserController@fans'
    ]);
    // 用户关注者
    $api->get('user/{id}/followers', [
        'as' => 'user.followers', 'uses' => 'UserController@followers'
    ]);

    // 热门用户列表
    $api->get('user/hot_users', [
        'as' => 'user.hot_users', 'uses' => 'UserController@hotUsers'
    ]);

    // 公共接口
    
    // 栏目列表
    $api->get('gateway/columns', [
        'as' => 'gateway.columns', 'uses' => 'GatewayController@columnList'
    ]);
    
    // 第三方登录跳转 
    $api->get('oauth/redirect/{driver}', 'OAuthController@redirectToProvider');
    // 第三方登录回调
    $api->get('oauth/callback/{driver}', 'OAuthController@handleProviderCallback');
    
    
    // 搜索列表接口
    $api->get('search/list', [
        'as' => 'search.list', 'uses' => 'SearchController@getList'
    ]);
    // 搜索建议
    $api->get('search/expanded', [
        'as' => 'search.expanded', 'uses' => 'SearchController@getExpanded'
    ]);
            
    // 验证API
    // 'jwt.refresh'
    $api->group(['middleware' => ['jwt.api.auth']], function($api) {
        
        $api->post('auth/logout', [
            'as' => 'auth.logout', 'uses' => 'AuthenticateController@logout'
        ]);
        
        // 上传头像
        $api->post('upload/avatar', [
            'as' => 'upload.avatar', 'uses' => 'UploadController@avatar'
        ]);
        
        // 更新用户Token
        $api->post('auth/upToken', [
            'as' => 'auth.upToken', 'uses' => 'AuthenticateController@upToken'
        ]);

        $api->get('auth/getAuthUser', [
            'as' => 'auth.user', 'uses' => 'AuthenticateController@getAuthUser'
        ]);

        // 获取七牛上传Token
        $api->get('upload/qiniuToken', [
            'as' => 'upload.token', 'uses' => 'UploadController@qiniuToken'
        ]);
        
        // 获取七牛上传视频Token
        $api->get('upload/videoToken', [
            'as' => 'upload.videotoken', 'uses' => 'UploadController@videoToken'
        ]); 
        
        // 获取七牛上传照片Token
        $api->get('upload/photoToken', [
            'as' => 'upload.phototoken', 'uses' => 'UploadController@photoToken'
        ]);
            
        // 获取七牛上传头像Token
        $api->get('upload/avatarToken', [
            'as' => 'upload.avatartoken', 'uses' => 'UploadController@avatarToken'
        ]);

        // 本地上传
        $api->post('upload/photo', [
            'as' => 'upload.photo', 'uses' => 'UploadController@photo'
        ]);
        
        $api->post('stuffs/store', [
            'as' => 'stuffs.store', 'uses' => 'StuffController@store'
        ]);
        $api->put('stuffs/{id}/destroy', [
            'as' => 'stuffs.destroy', 'uses' => 'StuffController@destroy'
        ])->where(['id' => '[0-9]+']);
        
        $api->put('stuffs/{id}/update', [
            'as' => 'stuffs.update', 'uses' => 'StuffController@update'
        ])->where(['id' => '[0-9]+']);
            
            
        // 发表回复
        $api->post('stuffs/{id}/postComment', [
            'as' => 'stuffs.postComment', 'uses' => 'StuffController@postComment'
        ]);
        // 删除回复
        $api->post('stuffs/destoryComment/{id}', [
            'as' => 'stuffs.destoryComment', 'uses' => 'StuffController@destoryComment'
        ]);
            
        $api->post('stuffs/{id}/dolike', [
            'as' => 'stuffs.dolike', 'uses' => 'StuffController@dolike'
        ]);
        $api->post('stuffs/{id}/cancelike', [
            'as' => 'stuffs.cancelike', 'uses' => 'StuffController@canceLike'
        ]);
        
        
        $api->put('tags/store', [
            'as' => 'tags.store', 'uses' => 'TagController@store'
        ]);
        $api->post('tags/{id}/destory', [
            'as' => 'tags.destory', 'uses' => 'TagController@destory'
        ]);
        $api->put('tags/{id}/update', [
            'as' => 'tags.update', 'uses' => 'TagController@update'
        ]);
        $api->put('tags/{id}/upStick', [
            'as' => 'tags.stick', 'uses' => 'TagController@upStick'
        ]);
            
        // 提交反馈意见
        $api->post('feedback/submit', [
            'as' => 'feedback.submit', 'uses' => 'FeedbackController@submited'
        ]);
        // 完成反馈意见状态
        $api->put('feedback/finfished/{id}', [
            'as' => 'feedback.finfished', 'uses' => 'FeedbackController@finfished'
        ]);
            
        // 关注
        $api->post('user/{id}/follow', [
            'as' => 'user.follow', 'uses' => 'UserController@follow'
        ]);
        // 取消关注
        $api->delete('user/{id}/cancelFollow', [
            'as' => 'user.cancelFollow', 'uses' => 'UserController@cancelFollow'
        ]);
          
        // 更新用户资料
        $api->post('user/settings', [
            'as' => 'user.settings', 'uses' => 'UserController@settings'
        ])->where(['id' => '[0-9]+']);
        
        // 获取个人信息
        $api->get('user/profile', [
            'as' => 'user.profile', 'uses' => 'UserController@profile'
        ]);
        
    });
    
    
    
});

// // 私有接口
// $api->version('v1', ['protected' => true], function ($api) {
//
// });


