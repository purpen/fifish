<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Models\User;
use App\Http\ApiHelper;

use App\Http\Transformers\UserTransformer;

class UserController extends BaseController
{
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
     * {
     *     "status": "success",
     *     "code": 200,
     *     "message": "更新成功！",
     *   }
     */
    public function settings()
    {
        
    }
    
    /**
     * 更新头像
     */
    public function avatar()
    {
        
    }
    
    /**
     * 
     */
    public function profile($id)
    {
        $user = User::findOrFail($id);
        
        return $this->response->item($user, new UserTransformer())->setMeta(ApiHelper::metaArray('获取用户信息成功'));
    }
    
}
