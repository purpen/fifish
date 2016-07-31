<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Models\User;
use App\Http\Models\Asset;
use App\Http\ApiHelper;

use Illuminate\Http\Request;

class StuffController extends BaseController
{
    /**
     * @api {get} /stuffs 获取分享列表
     * @apiVersion 1.0.0
     * @apiName stuff list 
     * @apiGroup Stuff
     *
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "data": [
     *
     *  ],
     *  "meta": {
     *    "status": "success",
     *    "code": 200,
     *    "message": "获取列表成功",
     *    "pagination": {
     *      "total": 2,
     *      "count": 2,
     *      "per_page": 20,
     *      "current_page": 1,
     *      "total_pages": 1,
     *      "links": []
     *    }
     *  }
     * }
     */
    public function getList()
    {
        
    }
    
    /**
     * @api {get} /stuffs/:id 显示分享详情
     * @apiVersion 1.0.0
     * @apiName stuff show 
     * @apiGroup Stuff
     *
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "data": [
     *
     *  ],
     *  "meta": {
     *    "status": "success",
     *    "code": 200,
     *    "message": "获取成功",
     *  }
     * }
     */
    public function show($id)
    {
        
    }
    
    /**
     * @api {post} /stuffs/store 新增分享信息
     * @apiVersion 1.0.0
     * @apiName stuff store 
     * @apiGroup Stuff
     *
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "data": [
     *
     *  ],
     *  "meta": {
     *    "status": "success",
     *    "code": 200,
     *    "message": "成功",
     *  }
     * }
     */
    public function store(Request $request)
    {
        
    }
    
    /**
     * @api {put} /stuffs/:id/update 更新分享信息
     * @apiVersion 1.0.0
     * @apiName stuff update 
     * @apiGroup Stuff
     *
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "data": [
     *
     *  ],
     *  "meta": {
     *    "status": "success",
     *    "code": 200,
     *    "message": "获取成功",
     *  }
     * }
     */
    public function update(Request $request, $id)
    {
        
    }
    
    /**
     * @api {post} /stuffs/:id/destory 删除分享信息
     * @apiVersion 1.0.0
     * @apiName stuff destory 
     * @apiGroup Stuff
     *
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "data": [
     *
     *  ],
     *  "meta": {
     *    "status": "success",
     *    "code": 200,
     *    "message": "获取成功",
     *  }
     * }
     */
    public function destroy($id)
    {
        //
    }
    
    
    /**
     * @api {post} /stuffs/:id/postComment 发表回复
     * @apiVersion 1.0.0
     * @apiName stuff post comment 
     * @apiGroup Stuff
     *
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "data": [
     *
     *  ],
     *  "meta": {
     *    "status": "success",
     *    "code": 200,
     *    "message": "获取成功",
     *  }
     * }
     */
    public function postComment()
    {
        
    }
    
}
