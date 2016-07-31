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
    public function profile($id)
    {
        $user = User::find($id);
        
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
    public function settings(Request $request, $id)
    {
        $payload = app('request')->only('username', 'job', 'zone');
        
        $user = User::find($id);
        
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
     * @api {post} /user/avatar 更新用户头像
     * @apiVersion 1.0.0
     * @apiName user avatar
     * @apiGroup User
     *
     * @apiParam {string} file 上传文件
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
    public function avatar(Request $request, $id)
    {
        $file = $request->file('avatar');
        if (!$file->isValid()) {
            return $this->response->array(ApiHelper::error('File is invalid!', 401));
        }
        // 图片上传
        $image = Imageupload::upload($file);
        
        // 构建数据
        $somedata = [];
        
        $somedata['user_id'] = $id;
        
        $somedata['filepath'] = $image['original_filedir'];
        $somedata['filename'] = $image['original_filename'];
        $somedata['width'] = $image['original_width'];
        $somedata['height'] = $image['original_height'];
        $somedata['size'] = $image['original_filesize'];
        $somedata['mime'] = $image['original_mime'];
        
        // 保存数据
        $asset = new Asset();
        $asset->fill($somedata);
        $res = $asset->save();
        
        if ($res) {
            $static_url = config('app.static_url');
            $image_url = $static_url.'/'.$somedata['filepath'];
        }
        
        return $this->response->array(ApiHelper::success('upload ok!', 200, ['image_url' => $image_url]));
    }
    
    
    
}
