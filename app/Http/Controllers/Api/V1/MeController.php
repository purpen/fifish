<?php
/**
 * 用户个人中心
 */
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Models\User;
use App\Http\Models\Like;
use App\Http\Models\Remind;

use Log;
use Hash;
use Validator;
use App\Http\ApiHelper;
use App\Http\Transformers\UserTransformer;
use App\Http\Transformers\LikeTransformer;
use App\Http\Transformers\RemindTransformer;

use App\Exceptions as ApiExceptions;

class MeController extends BaseController
{
    /**
     * @api {get} /me/profile 获取自己的信息
     * @apiVersion 1.0.0
     * @apiName me info
     * @apiGroup Me
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
     * @api {post} /me/settings 设置个人资料
     * @apiVersion 1.0.0
     * @apiName me settings
     * @apiGroup Me
     *
     * @apiParam {string} username 用户姓名
     * @apiParam {string} job 职业
     * @apiParam {string} zone 城市/地区
     * @apiParam {intger} sex 性别 （默认值：0；男：1；女：2)
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
        $user = User::find($this->auth_user_id);
        
        if (!$user) {
            return $this->response->array(ApiHelper::error('Not Found!', 404));
        }
        
        // 更新用户信息
        if ($request->has('username')) {
            // 验证用户名是否唯一
            $username = $request->input('username');
            if ($username != $user->username) {
                $is_exist = User::where('username', $username)->first();
                if ($is_exist) {
                    return $this->response->array(ApiHelper::error('用户名被占用!', 403));
                }
                // 不存在则更新
                $user->username = $username;
                
                Log::warning('Update user name: '.$username);
            }
        }
        
        if ($request->has('job')) {
            $user->job = $request->job;
        }
        if ($request->has('zone')) {
            $user->zone = $request->zone;
        }
        if ($request->has('sex')) {
            $user->sex = $request->sex;
        }
        
        $res = $user->save();
        
        Log::warning('Update user name result: '.$res);
        
        if (!$res) {
            return $this->response->array(ApiHelper::error('failed!', 412));
        }
        
        return $this->response->array(ApiHelper::success());
    }
    
    /**
     * @api {post} /me/updatePassword 修改密码
     * @apiVersion 1.0.0
     * @apiName me updatePassword
     * @apiGroup Me
     *
     * @apiParam {string} old_password 旧密码
     * @apiParam {string} new_password 新密码
     * @apiParam {string} confrim_password 确认密码
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
    public function updatePassword(Request $request)
    {
        // 验证规则
        $rules = [
            'old_password'  => ['required', 'min:6'],
            'new_password'  => ['required', 'min:6'],
            'confrim_password'  => ['required'],
        ];
        $messages = [
            'old_password.required' => '旧密码不能为空',
            'old_password.min' => '新密码不能小于6个字符',
            'new_password.required' => '新密码不能为空',
            'new_password.min' => '新密码不能小于6个字符',
            'confrim_password.required' => '确认密码不能为空',
        ];
        $check = Validator::make($request->all(), $rules, $messages);
        if ($check->fails()) {
            throw new ApiExceptions\ValidationException(trans('common.validate'), $check->errors());
        }
        
        $user = User::find($this->auth_user_id);
        if (!$user) {
            return $this->response->array(ApiHelper::error('Not Found!', 404));
        }
        // 验证旧密码是否相同
        if (!Hash::check($request->input('old_password'), $user->password)) {
            return $this->response->array(ApiHelper::error(trans('common.error_password'), 412));
        }
        
        // 验证新密码是否一致
        if ($request->input('new_password') != $request->input('confrim_password')) {
            return $this->response->array(ApiHelper::error(trans('common.confrim_password'), 501));
        }
        
        // 更新密码
        $user->password = bcrypt($request->input('new_password'));
        
        $res = $user->save();
        if (!$res) {
            return $this->response->array(ApiHelper::error(trans('common.failed'), 412));
        }
        
        return $this->response->array(ApiHelper::success());
    }
    
    /**
     * @api {get} /me/likeStuffs 我点赞过的作品列表
     * @apiVersion 1.0.0
     * @apiName me likeStuffs
     * @apiGroup Me
     *
     * @apiParam {intger} kind 默认：0；图片：1；视频：2； 
     * 
     * @apiSuccessExample 成功响应:
     *   {
     *     "data": [
     *       {
     *         "id": 2,
     *         "likeable": {
     *           "id": 11,
     *           "content": "一朵朵浪花拍打沙滩,发出轰轰的浪花声",
     *           "sticked": 1,
     *           "sticked_at": "2016-09-23 11:39:47",
     *           "featured": 1,
     *           "featured_at": "0000-00-00 00:00:00",
     *           "view_count": 0,
     *           "like_count": 0,
     *           "comment_count": 0,
     *           "created_at": "2016-09-23 11:39:47",
     *           "kind": 1,
     *           "address": null,
     *           "city": null,
     *           "cover": {
     *             "id": 16,
     *             "filepath": "photo/160923/161f976f62b5284ac1a5fcfe3c529121",
     *             "width": 750,
     *             "height": 422,
     *             "duration": 0,
     *             "kind": 1,
     *             "size": 0,
     *             "file": {
     *               "srcfile": "http://clouddn.com/photo/160923/161ffe3c529121",
     *               "small": "http://clouddn.com/photo/160923/161f9763c529121!cvxsm",
     *               "large": "http://clouddn.com/photo/160923/161f9cfe3c529121!cvxlg",
     *               "thumb": "http://clouddn.com/photo/160923/161f976cfe3c529121!psq",
     *               "adpic": "http://clouddn.com/photo/160923/161f976fe3c529121!plg"
     *             }
     *           }
     *         },
     *         "user": {
     *           "id": 6,
     *           "username": "xiaobengsex",
     *           "summary": null,
     *           "first_login": 1,
     *           "last_login": "2016-11-01 09:06:15",
     *           "avatar": {
     *             "small": "http://s3.qysea.com/img/avatar!smx50.png",
     *             "large": "http://s3.qysea.com/img/avatar!lgx180.png"
     *           }
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
    public function likeStuffs(Request $request)
    {
        $kind = $request->input('kind', 0);
        $per_page = $request->input('per_page', $this->per_page);
        
        if ($kind) {
            $likes = Like::where(['user_id' => $this->auth_user_id, 'likeable_type' => 'Stuff', 'kind' => $kind])->paginate($per_page);
        } else {
            $likes = Like::where(['user_id' => $this->auth_user_id, 'likeable_type' => 'Stuff'])->paginate($per_page);
        }
           
        return $this->response->paginator($likes, new LikeTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {get} /me/alertCount 消息的数量
     * @apiVersion 1.0.0
     * @apiName me alertCount
     * @apiGroup Me
     * 
     * @apiSuccessExample 成功响应:
     *   {
     *     "data": {
     *       "alert_fans_count": 0,
     *       "alert_like_count": 0,
     *       "alert_comment_count": 0
     *     },    
     *     "meta": {
     *       "message": "Success.",
     *       "status_code": 200,
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
    public function alertCount(Request $request)
    {
        $user = User::find($this->auth_user_id);
        
        if (!$user) {
            return $this->response->array(ApiHelper::error('Not Found!', 404));
        }
        // 提醒数量
        $counter = [
          'alert_fans_count' => $user->alert_fans_count,
          'alert_like_count' => $user->alert_like_count,
          'alert_comment_count' => $user->alert_comment_count  
        ];
        
        return $this->response->array(ApiHelper::success(trans('common.success'), 200, $counter));
    }
    
    /**
     * @api {post} /me/resetCount 重置消息的数量
     * @apiVersion 1.0.0
     * @apiName me resetCount
     * @apiGroup Me
     *
     * @apiParam {string} key 默认值：fans,like,comment
     * 
     * @apiSuccessExample 成功响应:
     *   {   
     *     "meta": {
     *       "message": "Success.",
     *       "status_code": 200,
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
    public function resetCount(Request $request)
    {        
        $key = $request->input('key');
        
        $user = User::find($this->auth_user_id);
        if (!$user) {
            return $this->response->array(ApiHelper::error('Not Found!', 404));
        }
        
        Log::debug('Reset alert count: '.$key);
        
        switch ($key) {
            case 'fans':
                $user->alert_fans_count = 0;
                break;
            case 'like':
                $user->alert_like_count = 0;
                break;
            case 'comment':
                $user->alert_comment_count = 0;
                break;
        }
        
        $res = $user->save();
        
        return $this->response->array(ApiHelper::success());
    }
    
    /**
     * @api {get} /me/gotComment 收到的评论列表
     * @apiVersion 1.0.0
     * @apiName me gotComment
     * @apiGroup Me
     * 
     * @apiSuccessExample 成功响应:
     *   {   
     *   "data": [
     *       {
     *         "id": 5,
     *         "evt": "评论了",
     *         "content": null,
     *         "remindable": {
     *           "id": 26,
     *           "user_id": 6,
     *           "target_id": 28,
     *           "content": "zheshiyigeping",
     *           "reply_user_id": 0,
     *           "like_count": 0,
     *           "type": 1,
     *           "created_at": "2016-11-10 15:03:23",
     *           "updated_at": "2016-11-10 15:03:23",
     *           "parent_id": 0
     *         },
     *         "sender": {
     *           "id": 6,
     *           "username": "haha",
     *           "summary": null,
     *           "first_login": 1,
     *           "last_login": "2016-11-01 09:06:15",
     *           "avatar": {
     *             "small": "http://s3.qysea.com/img/avatar!smx50.png",
     *             "large": "http://s3.qysea.com/img/avatar!lgx180.png"
     *           }
     *         },
     *         "created_at": {
     *           "date": "2016-11-10 15:03:23.000000",
     *           "timezone_type": 3,
     *           "timezone": "Asia/Shanghai"
     *         }
     *       },
     *     ],
     *     "meta": {
     *       "message": "Success.",
     *       "status_code": 200,
     *        "pagination": {
     *             "total": 5,
     *             "count": 5,
     *             "per_page": 10,
     *             "current_page": 1,
     *             "total_pages": 1,
     *             "links": []
     *           }
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
    public function gotComment(Request $request)
    {
        $per_page = $request->input('per_page', $this->per_page);
        
        $reminds = Remind::where(['user_id' => 1, 'evt' => config('const.events.comment')])->orderBy('created_at', 'desc')->paginate($per_page);
        
        return $this->response->paginator($reminds, new RemindTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {get} /me/gotLikes 收到的点赞列表
     * @apiVersion 1.0.0
     * @apiName me gotLikes
     * @apiGroup Me
     * 
     * @apiSuccessExample 成功响应:
     *   {   
     *   "data": [
     *       {
     *         "id": 5,
     *         "evt": "赞了",
     *         "content": null,
     *         "remindable": {
     *           "id": 26,
     *           "user_id": 6,
     *           "target_id": 28,
     *           "content": "zheshiyigeping",
     *           "reply_user_id": 0,
     *           "like_count": 0,
     *           "type": 1,
     *           "created_at": "2016-11-10 15:03:23",
     *           "updated_at": "2016-11-10 15:03:23",
     *           "parent_id": 0
     *         },
     *         "sender": {
     *           "id": 6,
     *           "username": "haha",
     *           "summary": null,
     *           "first_login": 1,
     *           "last_login": "2016-11-01 09:06:15",
     *           "avatar": {
     *             "small": "http://s3.qysea.com/img/avatar!smx50.png",
     *             "large": "http://s3.qysea.com/img/avatar!lgx180.png"
     *           }
     *         },
     *         "created_at": {
     *           "date": "2016-11-10 15:03:23.000000",
     *           "timezone_type": 3,
     *           "timezone": "Asia/Shanghai"
     *         }
     *       },
     *     ],
     *     "meta": {
     *       "message": "Success.",
     *       "status_code": 200,
     *        "pagination": {
     *             "total": 5,
     *             "count": 5,
     *             "per_page": 10,
     *             "current_page": 1,
     *             "total_pages": 1,
     *             "links": []
     *           }
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
    public function gotLikes(Request $request)
    {
        $per_page = $request->input('per_page', $this->per_page);
        
        $reminds = Remind::where(['user_id' => $this->auth_user_id, 'evt' => config('const.events.like')])->orderBy('created_at', 'desc')->paginate($per_page);
        
        return $this->response->paginator($reminds, new RemindTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {get} /me/editSign 编辑个性签名
     * @apiVersion 1.0.0
     * @apiName me editSign
     * @apiGroup Me
     * 
     * @apiSuccessExample 成功响应:
     *   {
     *     "meta": {
     *       "message": "success",
     *       "status_code": 200
     *     },
     *     "data": {
     *       "idtags": [
     *         "肌肉男",
     *         "路人甲",
     *         "老炮儿",
     *       ],
     *       "tags": [
     *         "肌肉男",
     *         "路人甲"
     *       ],
     *       "summary": "天道酬勤"
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
    public function editSign(Request $request)
    {
        $idtags = config('const.idtags');
        
        $user = User::find($this->auth_user_id);
        if (!$user) {
            return $this->response->array(ApiHelper::error('Not Found!', 404));
        }
        
        return $this->response->array(ApiHelper::success('success', 200, [
            'idtags' => $idtags,
            'tags' => $user->tags_label,
            'summary' => $user->summary,
        ]));
    }
    
    /**
     * @api {post} /me/updateSign 更新个性签名
     * @apiVersion 1.0.0
     * @apiName me updateSign
     * @apiGroup Me
     * 
     * @apiParam {string} tags 标签之间逗号隔开
     * @apiParam {string} summary 
     *
     * @apiSuccessExample 成功响应:
     *   {
     *     "meta": {
     *       "message": "Success.",
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
    public function updateSign(Request $request)
    {
        $user = User::find($this->auth_user_id);
        if (!$user) {
            return $this->response->array(ApiHelper::error('Not Found!', 404));
        }
        
        if ($request->has('tags')) {
            $user->tags = $request->tags;
        }
        if ($request->has('summary')) {
            $user->summary = $request->summary;
        }
        
        $res = $user->save();
        
        Log::warning('Update user sign result: '.$res);
        
        if (!$res) {
            return $this->response->array(ApiHelper::error('failed!', 412));
        }
        
        return $this->response->array(ApiHelper::success());
    }
    
}
