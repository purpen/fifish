<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Models\User;

class UserController extends BaseController
{
    /**
     * @api {post} /feedback 提交反馈信息
     * @apiVersion 0.0.1
     * @apiName feedback
     * @apiGroup Api
     *
     * @apiSuccess {String} contact 联系方式
     * @apiSuccess {String} content 反馈内容
     *
     * @apiSuccessExample 成功响应:
     *   {
     *       "data": {
     *           "contact":"44334512",
     *           "content":"提交一个测试反馈信息"
     *        },
     *       "meta": {
     *           "status": "success",
     *           "status_code": 200,
     *           "message": "提交反馈信息成功"
     *       }
     *   }
     * @apiErrorExample 失败响应:
     *   {
     *       "message": "提交反馈信息失败",
     *       "status_code": 404
     *   }
     */
    public function showProfile($id)
    {
        $user = User::findOrFail($id); 
        
        //throw new Symfony\Component\HttpKernel\Exception\ConflictHttpException('User was updated prior to your request.');
        //return $this->response->item($user, new UserTransformer);
        return $this->response->array($user->toArray());
    }
    
}
