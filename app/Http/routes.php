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

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/index', 'Home\HomeController@index');

Route::get('/login', 'Auth\AuthController@login');
Route::get('/register', 'Auth\AuthController@register');




/**
 * 后台管理的路由组
 */
Route::group(['middleware' => 'auth', 'namespace' => 'Admin', 'prefix' => 'admin'], function() {
    
    Route::get('/', 'BoardController@index');
    
    Route::resource('asset', 'AssetController');
    
});

