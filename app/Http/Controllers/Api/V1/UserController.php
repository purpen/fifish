<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Models\User;
use App\Http\Models\Asset;
use App\Http\ApiHelper;

use Storage;
use Imageupload;
use App\Http\Transformers\UserTransformer;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    /**
     * @api {get} /user/profile 获取个人信息
     * @apiVersion 1.0.0
     * @apiName user profile
     * @apiGroup User
     *
     * @apiSuccessExample 成功响应:
     *   {
     *     "data": {
     *       "id": 1,
     *       "account": "purpen.w@gmail.com",
     *       "username": "purpen",
     *       "job": "设计师",
     *       "zone": "北京",
     *       "avatar": {
     *         "small": "",
     *         "large": ""
     *      }
     *     },
     *     "meta": {
     *       "meta": {
     *         "message": "request ok",
     *         "status_code": 200
     *       }
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
    public function profile()
    {
        $user = User::find($this->auth_user_id);
        
        if (!$user) {
            return $this->response->array(ApiHelper::error('Not Found!', 404));
        }
        
        return $this->response->item($user, new UserTransformer())->setMeta(ApiHelper::success());
    }
    
    /**
     * @api {post} /user/settings 设置个人资料
     * @apiVersion 1.0.0
     * @apiName user settings
     * @apiGroup User
     *
     * @apiParam {string} username 用户姓名
     * @apiParam {string} job 职业
     * @apiParam {string} zone 城市/地区 
     * 
     * @apiSuccessExample 成功响应:
     *   {
     *     "meta": {
     *       "message": "Success！",
     *       "status_code": 200
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
    public function settings(Request $request)
    {
        $payload = app('request')->only('username', 'job', 'zone');
        
        $user = User::find($this->auth_user_id);
        
        if (!$user) {
            return $this->response->array(ApiHelper::error('Not Found!', 404));
        }
        
        // 更新用户信息
        if ($request->has('username')) {
            $user->username = $request->username;
        }
        if ($request->has('job')) {
            $user->job = $request->job;
        }
        if ($request->has('zone')) {
            $user->zone = $request->zone;
        }
        
        $res = $user->save();
        
        if (!$res) {
            return $this->response->array(ApiHelper::error('failed!', 412));
        }
        
        return $this->response->array(ApiHelper::success());
    }
    
    
    
}
