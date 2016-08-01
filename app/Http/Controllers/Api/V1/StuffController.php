<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Models\User;
use App\Http\Models\Asset;
use App\Http\Models\Stuff;
use App\Http\Transformers\StuffTransformer;

use App\Http\ApiHelper;

use Log;
use Illuminate\Http\Request;
use Dingo\Api\Exception as DingoException;
    
class StuffController extends BaseController
{   
    /**
     * @api {get} /stuffs 获取分享列表
     * @apiVersion 1.0.0
     * @apiName stuff list 
     * @apiGroup Stuff
     *
     * @apiParam {Integer} page 当前分页.
     * @apiParam {Integer} per_page 每页数量
     *
     * @apiSuccessExample 成功响应:
     *   {
     *       "data": [
     *           {
     *               "id": 10,
     *               "content": "这是重大的设计走势",
     *               "user_id": 10,
     *               "user": {
     *                     "id": 1,
     *                     "account": "purpen.w@gmail.com",
     *                     "username": "purpen",
     *                     "email": null,
     *                     "phone": "",
     *                     "avatar_url": "",
     *                     "job": "",
     *                     "zone": "",
     *                     "sex": 0,
     *                     "summary": null,
     *                     "follow_count": 0,
     *                     "fans_count": 0,
     *                     "stuff_count": 0,
     *                     "like_count": 0,
     *                     "tags": null,
     *                     "updated_at": "2016-08-01 18:42:06"
     *                   },
     *               "tags": "",
     *               "asset_id": 23
     *           },
     *           {
     *               "id": 9,
     *               "content": "这是重大的设计",
     *               "user_id": 0,
     *               "user": {
     *                  ...
     *                }
     *               "tags": "",
     *               "asset_id": 22
     *           }
     *       ],
     *       "meta": {
     *           "message": "Success.",
     *           "status_code": 200,
     *           "pagination": {
     *               "total": 10,
     *               "count": 2,
     *               "per_page": 2,
     *               "current_page": 1,
     *               "total_pages": 5,
     *               "links": {
     *                   "next": "http://fifish.me/api/stuffs?page=2"
     *               }
     *           }
     *       }
     *   }
     */
    public function getList(Request $request)
    {
        $per_page = $request->input('per_page', $this->per_page);
        
        $stuffs = Stuff::orderBy('created_at', 'desc')->paginate($per_page);
        
        return $this->response->paginator($stuffs, new StuffTransformer())->setMeta(ApiHelper::meta());
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
     *     "id": 11,
     *     "content": "这是一个新世界sdfsadfasdf",
     *    "user_id": 1,
     *       "user": {
     *         "id": 1,
     *         "account": "purpen.w@gmail.com",
     *         "username": "purpen",
     *          ...
     *       },
     *       "tags": "",
     *       "asset_id": 1
     *  ],
     *  "meta": {
     *    "status": "success",
     *    "code": 200,
     *    "message": "获取成功",
     *  }
     * }
     * @apiErrorExample 错误响应:
     *   {
     *     "meta": {
     *       "message": "Not Found！",
     *       "status_code": 404
     *     }
     *   }
     */
    public function show($id)
    {
        $stuff = Stuff::find($id);
        
        if (!$stuff) {
            return $this->response->array(ApiHelper::error('Not Found!', 404));
        }
        
        // 查看次数+1
        $stuff->increment('view_count');
        
        return $this->response->item($stuff, new StuffTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {post} /stuffs/store 新增分享信息
     * @apiVersion 1.0.0
     * @apiName stuff store 
     * @apiGroup Stuff
     *
     *
     * @apiSuccessExample 成功响应:
     *   {
     *     "data": {
     *       "id": 10,
     *       "content": "这是重大的设计走势",
     *       "user_id": 10,
     *       "tags": null,
     *       "asset_id": "23"
     *     },
     *     "meta": {
     *       "message": "Success.",
     *       "status_code": 200
     *     }
     *   }
     */
    public function store(Request $request)
    {
        $user_id = 1;
        // 验证规则
        $rules = [
            'content'  => ['required', 'min:5'],
            'asset_id' => ['required']
        ];
        $messages = [
            'content.required' => '内容不能为空',
            'content.min' => '内容长度不能小于5个字符',
            'asset_id.required' => '请选择一张图片'
        ];        
        $validator = app('validator')->make($request->only(['content', 'asset_id']), $rules, $messages);
        // 验证格式
        if ($validator->fails()) {
            throw new DingoException\ValidationHttpException('验证失败.', $validator->errors());
        }
        
        try {
            // 完善数据
            $somedata = $request->all();
            $somedata['user_id'] = $user_id;
            
            // 保存数据
            $stuff = new Stuff();
            $stuff->fill($somedata);
            $res = $stuff->save();
            
            Log::debug('Stuff save ok!');
            
            if (!$res) {
                throw new DingoException\StoreResourceFailedException('提交失败.', 501);
            }
        } catch (DingoException\StoreResourceFailedException $e) {
            return $this->response->array(ApiHelper::error('提交出错', 501));
        }
        
        return $this->response->item($stuff, new StuffTransformer())->setMeta(ApiHelper::meta());
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
     *    "message": "回复成功",
     *  }
     * }
     */
    public function postComment()
    {
        
    }
    
    /**
     * @api {post} /stuffs/:id/destoryComment 删除回复
     * @apiVersion 1.0.0
     * @apiName stuff destory comment 
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
     *    "message": "删除成功",
     *  }
     * }
     */
    public function destoryComment()
    {
        
    }
    
}
