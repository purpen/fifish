<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;

use Socialite;

class OAuthController extends BaseController
{
    /**
     * 跳转授权方法
     */
    public function redirectToProvider($driver)
    {
        return Socialite::driver($driver)->redirect();
    }
    
    /**
     * 回调处理方法
     */
    public function handleProviderCallback($driver)
    {
        $user = Socialite::driver($driver)->user();
        // todo: do something for user
        
    }
    
}
