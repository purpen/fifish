<?php

namespace App\Http\Controllers\Api\V1;

use Log;
use Illuminate\Http\Request;
use Dingo\Api\Exception as DingoException;
use Illuminate\Auth\Access\AuthorizationException;

use App\Http\Models\User;
use App\Http\Models\Asset;
use App\Http\Models\Stuff;
use App\Http\Models\Comment;
use App\Http\Transformers\StuffTransformer;
use App\Http\Transformers\CommentTransformer;

use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;

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
     * @apiParam {Integer} id 回复Id.
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
            throw new ApiExceptions\NotFoundException(404, trans('common.notfound'));
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
     * @apiParam {String} content 分享内容
     * @apiParam {File} file 上传文件
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
        // 验证规则
        $rules = [
            'content'  => ['required', 'min:5'],
        ];
        $messages = [
            'content.required' => '内容不能为空',
            'content.min' => '内容长度不能小于5个字符',
        ];
        
        $validator = app('validator')->make($request->only(['content']), $rules, $messages);
        // 验证格式
        if ($validator->fails()) {
            throw new ApiExceptions\ValidationException('验证格式出错！', $validator->errors());
        }
        
        // 完善数据
        $somedata = $request->all();
        $somedata['user_id'] = $this->auth_user_id;
        
        // 保存数据
        $stuff = new Stuff();
        $stuff->fill($somedata);
        $res = $stuff->save();
        
        Log::debug('Stuff save ok!');
        
        if (!$res) {
            throw new ApiExceptions\StoreFailedException(501, '提交失败.');
        }
        
        // 保存图片或视频
        $file = $request->file('file');
        if ($file) {
            $somedata = array(
                'user_id' => $this->auth_user_id,
                'target_id' => $stuff->id
            );
            $asset = new Asset();
            $assetInfo = $asset->localUpload($file, $somedata);
            
            // 更新附件Id
            $stuff->asset = $assetInfo['id'];
            $stuff->save();
        }
        
        return $this->response->item($stuff, new StuffTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {put} /stuffs/:id/update 更新分享信息
     * @apiVersion 1.0.0
     * @apiName stuff update 
     * @apiGroup Stuff
     *
     * @apiParam {Integer} id 回复Id.
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "meta": {
     *    "code": 200,
     *    "message": "Success.",
     *  }
     * }
     */
    public function update(Request $request, $id)
    {        
        $stuff = Stuff::find($id);
        if (!$stuff) {
            throw new ApiExceptions\NotFoundException(404, '该记录不存在或被删除！');
        }
        
        $somedata = $request->all();
        $somedata['user_id'] = $this->auth_user_id;
        
        $stuff->fill($somedata);
        $res = $stuff->save();
        
        if (!$res) {
            return $this->response->array(ApiHelper::error('更新失败!', 501));
        }
        
        return $this->response->array(ApiHelper::success());
    }
    
    /**
     * @api {post} /stuffs/:id/destory 删除分享信息
     * @apiVersion 1.0.0
     * @apiName stuff destory 
     * @apiGroup Stuff
     *
     * @apiParam {Integer} id 回复Id.
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "meta": {
     *    "code": 200,
     *    "message": "Success.",
     *  }
     * }
     */
    public function destroy($id)
    {
        $stuff = Stuff::find($id);
        if (!$stuff) {
            throw new ApiExceptions\NotFoundException(404, '该记录不存在或被删除！');
        }
        
        // 判断是否有删除权限
        if ($stuff->user_id != $this->auth_user_id) {
            throw new ApiExceptions\ValidationException('没有权限删除此记录！');
        }
        
        // 执行删除操作
        $res = $stuff->delete();
        
        return $this->response->array(ApiHelper::success());
    }
    
    /**
     * @api {post} /stuffs/:id/comments 某个分享的评论列表
     * @apiVersion 1.0.0
     * @apiName stuff comments
     * @apiGroup Stuff
     *
     * @apiParam {Integer} id 分享ID.
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "data": [
     *     {
     *          "id": 3,
     *         "content": "这是一条评论内容精选",
     *         "user": {
     *           "id": 1,
     *           "username": "xiaobeng",
     *           "summary": null
     *         },
     *         "like_count": 0
     *       }
     *  ],
     *  "meta": {
     *       "message": "Success.",
     *       "status_code": 200,
     *       "pagination": {
     *         "total": 4,
     *         "count": 2,
     *         "per_page": 2,
     *         "current_page": 1,
     *         "total_pages": 2,
     *         "links": {
     *           "next": "http://xxxx/api/stuffs/1/comments?page=2"
     *         }
     *  }
     * }
     */
    public function comments(Request $request, $id)
    {
        $stuff = Stuff::find($id);
        if (!$stuff) {
            throw new ApiExceptions\NotFoundException(404, trans('common.notfound'));
        }
        
        $per_page = $request->input('per_page', $this->per_page);
        
        $comments = $stuff->comments()->orderBy('created_at', 'desc')->paginate($per_page);
        
        return $this->response->paginator($comments, new CommentTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {post} /stuffs/:id/postComment 发表回复
     * @apiVersion 1.0.0
     * @apiName stuff post comment 
     * @apiGroup Stuff
     *
     * @apiParam {String} content 回复内容.
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "data": [
     *       "id": 5,
     *       "content": "这是一条评论内容精选大家电",
     *       "user": {
     *           "id": 1,
     *           "username": "xiaobeng",
     *           "summary": null
     *         },,
     *       "like_count": null
     *  ],
     *  "meta": {
     *    "status": "success",
     *    "code": 200,
     *    "message": "回复成功",
     *  }
     * }
     */
    public function postComment(Request $request, $id)
    {
        // 验证规则
        $rules = [
            'content'  => ['required', 'min:2'],
        ];
        $messages = [
            'content.required' => '内容不能为空',
            'content.min' => '内容长度不能小于2个字符',
        ];
    
        $validator = app('validator')->make($request->only(['content']), $rules, $messages);
        // 验证格式
        if ($validator->fails()) {
            throw new ApiExceptions\ValidationException(trans('common.validate'), $validator->errors());
        }
        
        $stuff = Stuff::find($id);
        if (!$stuff) {
            throw new ApiExceptions\NotFoundException(404, trans('common.notfound'));
        }
        
        $comment = $stuff->comments()->create([
           'content' => $request->input('content'),
           'user_id' => $this->auth_user_id,
        ]);
        
        if (!$comment) {
            throw new ApiExceptions\StoreFailedException(501, trans('common.failed'));
        }
        
        // 评论数+1
        $stuff->increment('comment_count');
        
        return $this->response->item($comment, new CommentTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {post} /stuffs/:id/destoryComment 删除回复
     * @apiVersion 1.0.0
     * @apiName stuff destory comment 
     * @apiGroup Stuff
     *
     * @apiParam {Integer} id 回复Id.
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
    public function destoryComment(Request $request)
    {
        $id = $request->input('id');
        $comment = Comment::find($id);
        if (!$comment) {
            throw new ApiExceptions\NotFoundException(404, trans('common.notfound'));
        }
        $stuff_id = $comment->target_id;
        if ($comment->delete()) {
            Stuff::findOrFail($stuff_id)->decrement('comment_count');
        }
        
        return $this->response->array(ApiHelper::success());
    }
    
}
