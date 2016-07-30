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



/**
 * 后台管理的路由组
 */
Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
    
    Route::get('/', 'BoardController@index');
    
    Route::resource('stuff', 'StuffController');
    Route::resource('asset', 'AssetController');
    
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
        
    $api->get('auth/getAuthUser', [
        'as' => 'auth.user', 'uses' => 'AuthenticateController@getAuthUser'
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
    
    // middleware: ['jwt.auth','jwt.refresh']
    $api->group(['middleware' => ''], function($api) {
        $api->get('user/{id}', [
            'as' => 'user', 'uses' => 'UserController@showProfile'
        ])->where(['id' => '[0-9]+']);
        
        $api->get('user/profile', [
            'as' => 'user.profile', 'uses' => 'UserController@showProfile'
        ]);
        
        
        
    });
    
    // $api->get('user/fans', [
    //     'as' => 'user.fans', 'uses' => 'UserController@fans'
    // ]);
    
});

// // 私有接口
// $api->version('v1', ['protected' => true], function ($api) {
//
// });


