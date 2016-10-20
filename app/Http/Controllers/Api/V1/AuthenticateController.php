<?php

namespace App\Http\Controllers\Api\V1;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;

use App\Http\ApiHelper;
use App\Http\Models\User;
use App\Exceptions as ApiExceptions;

class AuthenticateController extends BaseController
{
    /**
     * @api {post} /auth/register 用户注册
     * @apiVersion 1.0.0
     * @apiName user register
     * @apiGroup User
     *
     * @apiParam {string} account 用户账号（要求邮箱格式）
     * @apiParam {string} password 设置密码
     * 
     * @apiSuccessExample 成功响应:
     *  {
     *     "meta": {
     *       "message": "Success.",
     *       "status_code": 200
     *     }
     *   }
     */
    public function register () 
    {
        // 验证规则
        $rules = [
            'account' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6']
        ];
        
        $payload = app('request')->only('account', 'password', 'password_confirm');
        $validator = app('validator')->make($payload, $rules);
        
        // 验证格式
        if ($validator->fails()) {
            throw new ApiExceptions\ValidationException('新用户注册失败！', $validator->errors());
        }
        
        // 创建用户
        $res = User::create([
            'account' => $payload['account'],
            'username' => $payload['account'],
            'password' => bcrypt($payload['password']),
        ]);
        
        if ($res) {
            return $this->response->array(ApiHelper::success());
        } else {
            return $this->response->array(ApiHelper::error('注册失败，请重试!', 412));
        }
    } 
    
    /**
     * Aliases authenticate
     */
    public function login (Request $request) {
        return $this->authenticate($request);
    }
    
    /**
     * @api {post} /auth/login 用户登录
     * @apiVersion 1.0.0
     * @apiName user login
     * @apiGroup User
     *
     * @apiParam {string} account 用户账号（要求邮箱格式）
     * @apiParam {string} password 设置密码
     * 
     * @apiSuccessExample 成功响应:
     *   {
     *     "meta": {
     *       "message": "登录成功！",
     *       "status_code": 200
     *     },
     *     "data": {
     *       "token": "eyJ0eXAiOiiOiJIUzI1NiJ9.sIm5iZiI6MTzkifQ.piS_YZhOqsjAF4XbxELIs2y70cq8"
     *     }
     *   }
     */
    public function authenticate (Request $request)
    {
        $credentials = $request->only('account', 'password');
        
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->response->array(ApiHelper::error('invalid_credentials', 401));
            }
        } catch (JWTException $e) {
            return $this->response->array(ApiHelper::error('could_not_create_token', 500));
        }
        
        // return the token
        return $this->response->array(ApiHelper::success('登录成功！', 200, compact('token')));
    }
    
    /**
     * @api {post} /auth/logout 退出登录
     * 要求：收到响应后，同时客户端清除token
     *
     * @apiVersion 1.0.0
     * @apiName user logout
     * @apiGroup User
     *
     * @apiSuccessExample 成功响应:
     *  {
     *     "meta": {
     *       "message": "A token is required",
     *       "status_code": 500
     *     }
     *  }
     */
    public function logout()
    {
        // 强制Token失效
        $res = JWTAuth::invalidate(JWTAuth::getToken());
        
        return $this->response->array(ApiHelper::success());
    }
    
    /**
     * @api {post} /auth/upToken 更新或换取新Token
     * @apiVersion 1.0.0
     * @apiName user token
     * @apiGroup User
     *
     * @apiParam {string} token
     * 
     * @apiSuccessExample 成功响应:
     * {
     *     "meta": {
     *       "message": "更新Token成功！",
     *       "status_code": 200
     *     },
     *     "data": {
     *       "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2ZpZmlzaC5tZVwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTQ2OTg4NjExNCwiZXhwIjoxNDY5ODg5NzE0LCJuYmYiOjE0Njk4ODYxMTQsImp0aSI6IjAxN2JhNTRjNjJjMWU0ZWM4OTU1YzExYjg0MDk0YjIxIn0.G25OQH2047nC9_DLyfc6s88cm_5IdYuhIVxYgXGsDjk"
     *    }
     *   }
     */
    public function upToken()
    {
        $token = JWTAuth::refresh();
        return $this->response->array(ApiHelper::success('更新Token成功！', 200, compact('token')));
    }
    
    
}
