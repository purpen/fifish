<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests;

use Log;
use Socialite;
use JWTAuth;
use Validator;

use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\ApiHelper;
use App\Http\Models\User;
use App\Http\Utils\ImageUtil;
use App\Exceptions as ApiExceptions;

class OAuthController extends BaseController
{
    /**
     * 跳转授权方法
     */
    public function redirectToProvider($driver)
    {
        Log::debug('Socialite login: '.$driver);
        
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
    
    /**
     * @api {post} /oauth/wechat 微信登录接口
     * @apiVersion 1.0.0
     * @apiName oauth wechat
     * @apiGroup Oauth
     *
     * @apiParam {string} uid
     * @apiParam {string} accessToken
     * @apiParam {string} name
     * @apiParam {string} icon （可选）
     * @apiParam {string} gender （可选）
     * 
     * @apiSuccessExample 成功响应:
     *   { 
     *     "meta": {
     *       "message": "Success.",
     *       "status_code": 200,
     *     }
     *     "data": {
     *       "token": "eyJ0eXAiOiiOiJIUzI1NiJ9.sIm5iZiI6MTzkifQ.piS_YZhOqsjAF4XbxELIs2y70cq8",
     *       "first_login": 0, // 值为0时，表示第一次登录   
     *     }
     *   }
     *
     * @apiErrorExample 错误响应:
     *   {
     *     "meta": {
     *       "message": "Not Found！",
     *       "status_code": 404
     *     }
     *   }
     */
    public function wechat(Request $request)
    {
        $somedata = $request->only(['uid', 'accessToken', 'name', 'icon', 'gender']);
        return $this->handleToLogin('wechat', $somedata);
    }
    
    /**
     * @api {post} /oauth/facebook Facebook登录接口
     * @apiVersion 1.0.0
     * @apiName oauth facebook
     * @apiGroup Oauth
     *
     * @apiParam {string} uid
     * @apiParam {string} accessToken
     * @apiParam {string} name
     * @apiParam {string} icon（可选）
     * @apiParam {string} gender（可选）
     * 
     * @apiSuccessExample 成功响应:
     *   { 
     *     "meta": {
     *       "message": "Success.",
     *       "status_code": 200,
     *     },
     *     "data": {
     *       "token": "eyJ0eXAiOiiOiJIUzI1NiJ9.sIm5iZiI6MTzkifQ.piS_YZhOqsjAF4XbxELIs2y70cq8",
     *       "first_login": 0, // 值为0时，表示第一次登录   
     *     }
     *   }
     *
     * @apiErrorExample 错误响应:
     *   {
     *     "meta": {
     *       "message": "Not Found！",
     *       "status_code": 404
     *     }
     *   }
     */
    public function facebook(Request $request)
    {
        $somedata = $request->only(['uid', 'accessToken', 'name', 'icon', 'gender']);
        return $this->handleToLogin('facebook', $somedata);
    }
    
    /**
     * @api {post} /oauth/instagram Instagram登录接口
     * @apiVersion 1.0.0
     * @apiName oauth instagram
     * @apiGroup Oauth
     *
     * @apiParam {string} uid
     * @apiParam {string} accessToken
     * @apiParam {string} name
     * @apiParam {string} icon（可选）
     * @apiParam {string} gender（可选）
     * 
     * @apiSuccessExample 成功响应:
     *   { 
     *     "meta": {
     *       "message": "Success.",
     *       "status_code": 200,
     *     },
     *     "data": {
     *       "token": "eyJ0eXAiOiiOiJIUzI1NiJ9.sIm5iZiI6MTzkifQ.piS_YZhOqsjAF4XbxELIs2y70cq8",
     *       "first_login": 0, // 值为0时，表示第一次登录   
     *     }
     *   }
     *
     * @apiErrorExample 错误响应:
     *   {
     *     "meta": {
     *       "message": "Not Found！",
     *       "status_code": 404
     *     }
     *   }
     */
    public function instagram(Request $request)
    {
        $somedata = $request->only(['uid', 'accessToken', 'name', 'icon', 'gender']);
        return $this->handleToLogin('instagram', $somedata);
    }
    
    /**
     * 第三方处理登录过程
     */
    protected function handleToLogin($type, $somedata)
    {
        $newdata = [];
        
        // 验证规则
        $rules = [
            'uid' => ['required'],
            'accessToken' => ['required']
        ];
        $messages = [
            'uid.required' => 'Openid不能为空',
            'accessToken.required' => '授权Token不能为空',
        ];
        $check = Validator::make($somedata, $rules, $messages);
        if ($check->fails()) {
            throw new ApiExceptions\ValidationException(trans('common.validate'), $check->errors());
        }
        
        // 1、查询是否存在某个用户；
        $user = User::OfSocialite($type, $somedata['uid'])->first();
        
        // 2、如不存在则自动注册新用户
        if (!$user) {
            $newdata = [
                'username' => $somedata['name'],
                'sex' => $somedata['gender'],
                'account' => $somedata['uid'].'@qysea.com',
            ];
            switch ($type) {
                case 'wechat':
                    $newdata = array_merge($newdata, [
                        'wechat_openid' => $somedata['uid'],
                        'wechat_access_token' => $somedata['accessToken'],
                        'password' => bcrypt(config('const.wechat.password')),
                        'from_site' => config('const.wechat.type'),
                    ]);
                    break;
                case 'facebook':
                    $newdata = array_merge($newdata, [
                        'facebook_openid' => $somedata['uid'],
                        'facebook_access_token' => $somedata['accessToken'],
                        'password' => bcrypt(config('const.facebook.password')),
                        'from_site' => config('const.facebook.type'),
                    ]);
                    break;
                case 'instagram':
                    $newdata = array_merge($newdata, [
                        'instagram_openid' => $somedata['uid'],
                        'instagram_access_token' => $somedata['accessToken'],
                        'password' => bcrypt(config('const.instagram.password')),
                        'from_site' => config('const.instagram.type'),
                    ]);
                    break;
                default:
                    return $this->response->array(ApiHelper::error('登录失败，请重试!', 412));
            }
            
            $res = User::create($newdata);
            if (!$res) {
                return $this->response->array(ApiHelper::error('登录失败，请重试!', 412));
            }
            // 获取用户
            $user = User::OfSocialite($type, $somedata['uid'])->first();
            
            // 自动存储用户头像
            if (!empty($somedata['icon'])) {
                $file_content = file_get_contents($somedata['icon'], FILE_USE_INCLUDE_PATH);
                $upRet = ImageUtil::storeContentQiniu($file_content, 'avatar', $user->id, 'User', $user->id);
                if (!$upRet) {
                    throw new ApiExceptions\StoreFailedException(501, '头像保存失败.');
                }
            }
        }
        
        try {
            // 实现自助登录
            $credentials = array(
                'account' => $user->account,
                'password' => config('const.'.$type.'.password'),
            );
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->response->array(ApiHelper::error('invalid_credentials', 401));
            }
            
            $first_login = $user->first_login;
            // 更新用户登录状态
            if (!$first_login) {
                $user->first_login = true;
                $user->last_login = date('Y-m-d H:i:s');
                $user->save();
            }
        } catch (JWTException $e) {
            return $this->response->array(ApiHelper::error('could_not_create_token', 500));
        }
        
        // return the token
        return $this->response->array(ApiHelper::success('登录成功！', 200, compact('token', 'first_login')));
    }
    
}
