<?php
/**
 * 用户个人中心
 */
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Http\Models\User;
use App\Http\Models\Like;

use App\Http\ApiHelper;
use App\Http\Transformers\LikeTransformer;
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
    
}
