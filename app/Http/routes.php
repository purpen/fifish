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


Route::get('/', 'HomeController@index');

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/job', 'HomeController@job');

/**
 * 后台管理的路由组
 */
Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
    
    Route::get('/', 'BoardController@index');
    
    Route::resource('stuff', 'StuffController');
    Route::resource('asset', 'AssetController');
    
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
    $api->post('auth/logout', [
        'as' => 'auth.logout', 'uses' => 'AuthenticateController@logout'
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
    // 七牛上传回调
    $api->post('upload/qiniuback', [
        'as' => 'upload.qiniuback', 'uses' => 'UploadController@qiniuback'
    ]);
    
    // 本地上传
    $api->post('upload/photo', [
        'as' => 'upload.photo', 'uses' => 'UploadController@photo'
    ]);
    // 上传头像
    $api->post('upload/avatar', [
        'as' => 'upload.avatar', 'uses' => 'UploadController@avatar'
    ]);
    
    /**
     * 分享相关路由
     */    
    $api->get('stuffs', [
        'as' => 'stuffs', 'uses' => 'StuffController@getList'
    ]);
    $api->get('stuffs/stickList', [
        'as' => 'stuffs.sticklist', 'uses' => 'StuffController@stickList'
    ]);
    $api->get('stuffs/featureList', [
        'as' => 'stuffs.featurelist', 'uses' => 'StuffController@featureList'
    ]);
    $api->get('stuffs/{id}', [
        'as' => 'stuffs.show', 'uses' => 'StuffController@show'
    ])->where(['id' => '[0-9]+']);
      
    $api->post('stuffs/store', [
        'as' => 'stuffs.store', 'uses' => 'StuffController@store'
    ]);
    $api->put('stuffs/{id}/destroy', [
        'as' => 'stuffs.destroy', 'uses' => 'StuffController@destroy'
    ])->where(['id' => '[0-9]+']);
    
    
    /**
     * 分享相关路由
     */    
    $api->get('stuffs/{id}/comments', [
        'as' => 'stuffs.comments', 'uses' => 'StuffController@comments'
    ]);
    // 发表回复
    $api->post('stuffs/{id}/postComment', [
        'as' => 'stuffs.postComment', 'uses' => 'StuffController@postComment'
    ]);
    // 删除回复
    $api->post('stuffs/destoryComment/{id}', [
        'as' => 'stuffs.destoryComment', 'uses' => 'StuffController@destoryComment'
    ]);
    
    /**
     * 点赞相关
     */
    $api->get('stuffs/{id}/likes', [
        'as' => 'stuffs.likes', 'uses' => 'StuffController@likes'
    ]);
    $api->post('stuffs/{id}/dolike', [
        'as' => 'stuffs.dolike', 'uses' => 'StuffController@dolike'
    ]);
    $api->post('stuffs/cancelike/{id}', [
        'as' => 'stuffs.cancelike', 'uses' => 'StuffController@cancelike'
    ]);
    
    /**
     * 标签相关
     */
    $api->get('tags', [
        'as' => 'tags', 'uses' => 'TagController@getList'
    ]);
    $api->post('tags/store', [
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
    
    // 反馈意见列表
    $api->get('feedback/{state?}', [
        'as' => 'feedback.getlist', 'uses' => 'FeedbackController@getList'
    ])->where(['state' => '[0-9]+']);
    // 提交反馈意见
    $api->post('feedback/submit', [
        'as' => 'feedback.submit', 'uses' => 'FeedbackController@submited'
    ]);
    // 完成反馈意见状态
    $api->put('feedback/finfished/{id}', [
        'as' => 'feedback.finfished', 'uses' => 'FeedbackController@finfished'
    ]);
    
    $api->get('user/{id}', [
        'as' => 'user', 'uses' => 'UserController@profile'
    ])->where(['id' => '[0-9]+']);
    
    // 更新用户资料
    $api->post('user/settings', [
        'as' => 'user.settings', 'uses' => 'UserController@settings'
    ])->where(['id' => '[0-9]+']);
    // 获取个人信息
    $api->get('user/profile', [
        'as' => 'user.profile', 'uses' => 'UserController@profile'
    ]);
            
    // middleware: ['jwt.auth','jwt.refresh']
    $api->group(['middleware' => ['jwt.auth','jwt.refresh']], function($api) {
        $api->put('stuffs/{id}/update', [
            'as' => 'stuffs.update', 'uses' => 'StuffController@update'
        ])->where(['id' => '[0-9]+']);
    });
    
    // $api->get('user/fans', [
    //     'as' => 'user.fans', 'uses' => 'UserController@fans'
    // ]);
    
});

// // 私有接口
// $api->version('v1', ['protected' => true], function ($api) {
//
// });


