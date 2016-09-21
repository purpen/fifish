<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Models\User;
use App\Http\Models\Asset;
use App\Http\Models\Follow;
use App\Http\ApiHelper;

use Storage;
use Imageupload;
use App\Http\Transformers\UserTransformer;
use App\Http\Transformers\FollowTransformer;
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
        
        return $this->response->item($user, new UserTransformer())->setMeta(ApiHelper::meta());
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
    
    /**
     * @api {post} /user/{id}/follow 关注某人
     * @apiVersion 1.0.0
     * @apiName user follow
     * @apiGroup User
     *
     * @apiParam {Integer} id 关注者ID
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
    public function follow(Request $request, $id)
    {
        $user = User::find($this->auth_user_id);
        
        if (!$user) {
            return $this->response->array(ApiHelper::error('Not Found!', 404));
        }
        
        $res = $user->followers()->create([
           'follow_id' => $id 
        ]);
        if (!$res) {
            return $this->response->array(ApiHelper::error('failed!', 412));
        }
        
        return $this->response->array(ApiHelper::success());
    }
    
    /**
     * @api {delete} /user/{id}/cancelFollow 取消关注某人
     * @apiVersion 1.0.0
     * @apiName user cancelFollow
     * @apiGroup User
     *
     * @apiParam {Integer} id 取消关注者ID
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
    public function cancelFollow(Request $request, $id)
    {
        $user = User::find($this->auth_user_id);
        
        if (!$user) {
            return $this->response->array(ApiHelper::error('Not Found!', 404));
        }
        // first()务必添加，触发deleted事件
        $res = $user->followers()->where('follow_id', $id)->first()->delete();
        if (!$res) {
            return $this->response->array(ApiHelper::error('failed!', 412));
        }
        
        return $this->response->array(ApiHelper::success());
    }
    
    /**
     * @api {get} /user/{id}/fans 获取某人的粉丝
     * @apiVersion 1.0.0
     * @apiName user fans
     * @apiGroup User
     *
     * @apiSuccessExample 成功响应:
     *   {
     *      "data": [
     *       {
     *         "id": 1,
     *         "user_id": 6,
     *         "user": {
     *           "id": 6,
     *           "username": "pen",
     *           "summary": null
     *         },
     *         "follow_id": 2,
     *         "follower": {
     *           "id": 2,
     *           "username": "xiao",
     *           "summary": null
     *         }
     *       }
     *     ],
     *     "meta": {
     *       "message": "Success.",
     *       "status_code": 200,
     *       "pagination": {
     *         "total": 1,
     *         "count": 1,
     *         "per_page": 10,
     *         "current_page": 1,
     *         "total_pages": 1,
     *         "links": []
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
    public function fans(Request $request, $id)
    {
        $per_page = $request->input('per_page', $this->per_page);
        
        $follows = Follow::with('user', 'follower')->OfFans($id)->orderBy('id', 'desc')->paginate($per_page);
        
        return $this->response->paginator($follows, new FollowTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {get} /user/{id}/followers 获取某人的关注者
     * @apiVersion 1.0.0
     * @apiName user followers
     * @apiGroup User
     *
     * @apiSuccessExample 成功响应:
     *   {
     *      "data": [
     *       {
     *         "id": 1,
     *         "user_id": 6,
     *         "user": {
     *           "id": 6,
     *           "username": "pen",
     *           "summary": null
     *         },
     *         "follow_id": 2,
     *         "follower": {
     *           "id": 2,
     *           "username": "xiao",
     *           "summary": null
     *         }
     *         "is_follow": 1,  // 当前用户是否已关注此用户: 0.否; 1.是;
     *       }
     *     ],
     *     "meta": {
     *       "message": "Success.",
     *       "status_code": 200,
     *       "pagination": {
     *         "total": 1,
     *         "count": 1,
     *         "per_page": 10,
     *         "current_page": 1,
     *         "total_pages": 1,
     *         "links": []
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
    public function followers(Request $request, $id)
    {
        $per_page = $request->input('per_page', $this->per_page);
        
        $follows = Follow::with('user', 'follower')->OfFollowers($id)->orderBy('id', 'desc')->paginate($per_page);
        
        return $this->response->paginator($follows, new FollowTransformer())->setMeta(ApiHelper::meta());
    }
    
    
    
}
