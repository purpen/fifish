<?php
/**
 * 个人主页
 */
namespace App\Http\Controllers\Api\V1;

use App\Http\Models\User;
use App\Http\Models\Asset;
use App\Http\Models\Follow;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;

use Log;
use Hash;
use Storage;
use Validator;
use Imageupload;
use App\Http\Transformers\UserTransformer;
use App\Http\Transformers\FollowTransformer;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    
    /**
     * @api {get} /user/{id} 获取他人的信息
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
     *       "sex": 0,
     *       "zone": "北京",
     *       "avatar": {
     *         "small": "",
     *         "large": ""
     *       },
     *       "first_login": false,
     *       "following": true,
     *       "alert_total_count": 1,
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
    public function index(Request $request, $id)
    {
        $user = User::find($id);
        
        if (!$user) {
            return $this->response->array(ApiHelper::error('Not Found!', 404));
        }
        
        return $this->response->item($user, new UserTransformer(['user_id' => $this->auth_user_id]))->setMeta(ApiHelper::meta());
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
        
        // 更新提醒的数量
        User::findOrFail($id)->increment('alert_fans_count');
        
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
     *           "avatar_url": "img_url",
     *           "summary": null
     *         },
     *         "follow_id": 2,
     *         "follower": {
     *           "id": 2,
     *           "username": "xiao",
     *           "avatar_url": "img_url",
     *           "summary": null
     *         },
     *         "is_follow": true    // 当前用户是否关注了此用户
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
        
        return $this->response->paginator($follows, new FollowTransformer(['user_id' => $this->auth_user_id]))->setMeta(ApiHelper::meta());
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
     *           "avatar_url": "",
     *           "summary": null
     *         },
     *         "follow_id": 2,
     *         "follower": {
     *           "id": 2,
     *           "username": "xiao",
     *           "avatar_url": "",
     *           "summary": null
     *         }
     *         "is_follow": true,  // 当前用户是否已关注此用户
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

        return $this->response->paginator($follows, new FollowTransformer(['user_id' => $this->auth_user_id]))->setMeta(ApiHelper::meta());
    }


    /**
     * @api {get} /user/hot_users 热门用户列表
     * @apiVersion 1.0.0
     * @apiName user hotUsers
     * @apiGroup User
     *
     * @apiSuccessExample 成功响应:
     *   {
     *      "data": [
     *       {
     *         "id": 1,
     *         "account": "tian_05@sina.com",
     *         "username": "tian_05@sina.com",
     *         "job": "程序猿",
     *         "zone": "",
     *         "summary": "",
     *         "follow_count": 10,
     *         "fans_count": 10,
     *         "stuff_count": 12,
     *         "like_count": 15,
     *         "avatar": {
     *           "small": 2,
     *           "large": "xiao"
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
    public function hotUsers(Request $request)
    {
        $user_ids = array(
            1,2,8,9,10,11,12,14,15,16,17,18,19,20
        );
        $per_page = $request->input('per_page', $this->per_page);

        $users = $stuff = User::whereIn('id', $user_ids)->paginate($per_page);
        
        return $this->response->paginator($users, new UserTransformer())->setMeta(ApiHelper::meta());
    }
    
}
