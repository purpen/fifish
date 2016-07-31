<?php

namespace App\Http\Controllers\Api\V1;

use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;
use Dingo\Api\Exception as DingoException;

use App\Http\ApiHelper;
use App\Http\Models\User;

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
     *   {
     *     "status": "success",  
     *     "code": 200,
     *     "message": "注册成功",
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
            throw new DingoException\StoreResourceFailedException('新用户注册失败.', $validator->errors());
        }
        
        // 创建用户
        $res = User::create([
            'account' => $payload['account'],
            'password' => bcrypt($payload['password']),
        ]);
        
        if ($res) {
            return $this->response->array(ApiHelper::success());
        } else {
            return $this->response->error('注册失败，请重试！', 412);
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
     * {
     *     "code": 200,
     *     "message": "登录成功！",
     *     "data": {
     *       "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL2ZpZmlzaC5tZVwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTQ2OTg4NjExNCwiZXhwIjoxNDY5ODg5NzE0LCJuYmYiOjE0Njk4ODYxMTQsImp0aSI6IjAxN2JhNTRjNjJjMWU0ZWM4OTU1YzExYjg0MDk0YjIxIn0.G25OQH2047nC9_DLyfc6s88cm_5IdYuhIVxYgXGsDjk"
     *    }
     *   }
     */
    public function authenticate (Request $request)
    {
        $credentials = $request->only('account', 'password');
        
        try {
            // attempt to verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {
                return $this->response->array(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return $this->response->array(['error' => 'could_not_create_token'], 500);
        }
        
        // return the token
        return $this->response->array(ApiHelper::success('登录成功！', 200, compact('token')));
    }
    
    /**
     * @api {post} /auth/upToken 更新Token
     * @apiVersion 1.0.0
     * @apiName user token
     * @apiGroup User
     *
     * 
     * @apiSuccessExample 成功响应:
     * {
     *     "code": 200,
     *     "message": "更新Token成功！",
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
    
    
    /**
     * 通过Token获取登录用户
     */
    public function getAuthUser () 
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }
        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['token_invalid'], $e->getStatusCode());
        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['token_absent'], $e->getStatusCode());
        }
        
        return response()->json(compact('user'));
    }
    
    
}
