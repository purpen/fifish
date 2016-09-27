<?php

namespace App\Http\Controllers\Api\V1;

use Log;
use Illuminate\Http\Request;
use Dingo\Api\Exception as DingoException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;

use App\Http\Models\User;
use App\Http\Models\Asset;
use App\Http\Models\Stuff;
use App\Http\Models\Comment;
use App\Http\Models\Like;
use App\Http\Transformers\StuffTransformer;
use App\Http\Transformers\CommentTransformer;
use App\Http\Transformers\LikeTransformer;

use App\Http\ApiHelper;
use App\Http\Utils\ImageUtil;
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
     * @apiParam {Integer} kind 类型：1.图片；2.视频
     * @apiParam {Integer} user_id 用户ID
     * @apiParam {Integer} sort 排序：0.最新；1.--；
     *
     * @apiSuccessExample 成功响应:
     *   {
     *       "data": [
     *           {
     *                 "id": 6,
     *                 "content": "开始上传一个图片",
     *                 "user_id": 1,
     *                 "kind": 1,   // 类型：1.图片；2.视频；
     *                 "city": "北京",
     *                 "address": "798艺术区",
     *                 "user": {
     *                   "id": 1,
     *                   "username": "xiaobeng",
     *                   "summary": null,
     *                   "avatar_url": "",
     *                 },
     *                 "tags": [
     *                   {
     *                     "id": 2,
     *                     "name": "时尚",
     *                     "display_name": "时尚的风格",
     *                     "total_count": 0
     *                   },
     *                   {
     *                     "id": 4,
     *                     "name": "科技",
     *                     "display_name": "科技风格",
     *                     "total_count": 0
     *                   }
     *                 ],
     *                 "photo": {
     *                   "id": 7,
     *                   "size": "105k",
     *                   "width": 1000,
     *                   "height": 1000,
     *                   "file": {
     *                       "small" => "http://static.fifish.me/uploads/images/a1bdbee1ffd2c058d3a26b4a397e6b5a.jpg",
     *                       "large" => "http://static.fifish.me/uploads/images/a1bdbee1ffd2c058d3a26b4a397e6b5a.jpg"
     *                    }              
     *                 },
     *                 "is_love": true, // 当前用户是否点赞此作品
     *                 "created_at": "2012-12-12",
     *               },
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
        $user_id = $request->input('user_id', 0);
        $kind = $request->input('kind', 0);

        $query = array();
        if($user_id){
            $query['user_id'] = (int)$user_id;
        }
        if($kind){
            $query['kind'] = (int)$kind;
        }
        
        $stuffs = Stuff::with('user')->where($query)->orderBy('created_at', 'desc')->paginate($per_page);
        
        return $this->response->paginator($stuffs, new StuffTransformer(array('user_id'=>$this->auth_user_id)))->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {get} /stuffs 获取推荐的分享列表
     * @apiVersion 1.0.0
     * @apiName stuff sticklist 
     * @apiGroup Stuff
     *
     * @apiParam {Integer} page 当前分页.
     * @apiParam {Integer} per_page 每页数量
     *
     * @apiSuccessExample 成功响应:
     * {
     *     // same to getList
     * }
     */
    public function stickList(Request $request)
    {
        $per_page = $request->input('per_page', $this->per_page);
        
        $stuffs = Stuff::sticked()->with('user')->orderBy('created_at', 'desc')->paginate($per_page);
        
        return $this->response->paginator($stuffs, new StuffTransformer(array('user_id'=>$this->auth_user_id)))->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {get} /stuffs 获取精选的分享列表
     * @apiVersion 1.0.0
     * @apiName stuff featurelist 
     * @apiGroup Stuff
     *
     * @apiParam {Integer} page 当前分页.
     * @apiParam {Integer} per_page 每页数量
     *
     * @apiSuccessExample 成功响应:
     * {
     *     // same to getList
     * }
     */
    public function featureList(Request $request)
    {
        $per_page = $request->input('per_page', $this->per_page);
        
        $stuffs = Stuff::featured()->with('user')->orderBy('created_at', 'desc')->paginate($per_page);
        
        return $this->response->paginator($stuffs, new StuffTransformer(array('user_id'=>$this->auth_user_id)))->setMeta(ApiHelper::meta());
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
        
        return $this->response->item($stuff, new StuffTransformer(array('user_id'=>$this->auth_user_id)))->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {post} /stuffs/store 新增分享信息
     * @apiVersion 1.0.0
     * @apiName stuff store 
     * @apiGroup Stuff
     *
     * @apiParam {String} content 分享内容
     * @apiParam {File} file 上传文件
     * @apiParam {String} city 城市名
     * @apiParam {String} address 地址
     * @apiParam {Integer} kind 类型：1.图片；2.视频 
     * @apiParam {Array} tags 标签ID
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
        
        // 更新图片或视频（支持图片或视频先上传后保存资料）
        $asset_id = $request->input('asset_id');
        if ($asset_id) {
            $asset = Asset::findOrFail($asset_id);
            $asset->assetable_id = $stuff->id;
            $asset->save();
        }
        
        // 保存照片或视频
        $file = $request->file('file');
        if ($file) {                
            $upRet = ImageUtil::storeQiniuCloud($file, 'photo', $stuff->id, 'Stuff', $this->auth_user_id);
            if (!$upRet) {
                throw new ApiExceptions\StoreFailedException(501, '照片保存失败.');
            }
        }
        
        // 同步保存标签
        $tags = $request->input('tags', []);
        if (!empty($tags)) {
            $stuff->tags()->sync($tags, ['updated_at' => date('Y-m-d H:i:s')]);
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
     *    "status_code": 200,
     *    "message": "Success.",
     *  }
     * }
     */
    public function destory($id)
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
     * @api {get} /stuffs/:id/comments 某个分享的评论列表
     * @apiParam {Integer} page 当前分页.
     * @apiParam {Integer} per_page 每页数量
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
     *           "summary": null,
     *            "avatar": {
     *               "small": "http://clouddn.com/uploads/images/cf56091a3f38d579c814f1025cb498c7.jpg!smx50",
     *               "large": "http://clouddn.com/uploads/images/cf56091a3f38d579c814f1025cb498c7.jpg!lgx180"
     *            }
     *         },
     *         "like_count": 0,
     *         "reply_user": [],
     *         "created_at": '',
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
     * @apiParam {Integer} reply_user_id 回复某人（可选）
     * @apiParam {Integer} parent_id 回复ID (可选)
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
     *    "status_code": 200,
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
           'reply_user_id' => (int)$request->input('reply_user_id', 0),
           'parent_id' => (int)$request->input('parent_id', 0),
        ]);
        
        if (!$comment) {
            throw new ApiExceptions\StoreFailedException(501, trans('common.failed'));
        }
        
        return $this->response->item($comment, new CommentTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {post} /stuffs/destoryComment/:id 删除回复
     * @apiVersion 1.0.0
     * @apiName stuff destory comment 
     * @apiGroup Stuff
     *
     * @apiParam {Integer} id 回复Id.
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "meta": {
     *    "status_code": 200,
     *    "message": "删除成功",
     *  }
     * }
     */
    public function destoryComment(Request $request, $id)
    {
        $comment = Comment::find($id);
        if (!$comment) {
            throw new ApiExceptions\NotFoundException(404, trans('common.notfound'));
        }
        // todo: 验证是否有删除权限
        
        $res = $comment->delete();
        
        return $this->response->array(ApiHelper::success());
    }
    
    
    /**
     * @api {post} /stuffs/:id/likes 分享点赞列表
     * @apiVersion 1.0.0
     * @apiName stuff likes
     * @apiGroup Stuff
     *
     * @apiParam {Integer} id 分享ID.
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "data": [
     *     {
     *       "id": 28,
     *       "likeable": {
     *         "id": 1,
     *         "user_id": 1,
     *         "asset": {
     *           "id": 7,
     *           "type": 1,
     *           "filepath": "uploads/images/d80b538b2c3c98cac393a81bb81cf0e9.jpg",
     *           "size": 77465,
     *         },
     *         "content": "开始上传文件",
     *         "tags": "",
     *         "sticked": 1,
     *         "featured": 1,
     *         "view_count": 0,
     *         "like_count": 13,
     *         "comment_count": -2,
     *       },
     *       "user": {
     *         "id": 1,
     *         "username": "xiaobeng",
     *         "summary": null
     *       }
     *    }
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
     *           "next": "http://xxxx/api/stuffs/1/likes?page=2"
     *         }
     *  }
     * }
     */
    public function likes(Request $request, $id)
    {
        $stuff = Stuff::find($id);
        if (!$stuff) {
            throw new ApiExceptions\NotFoundException(404, trans('common.notfound'));
        }
        
        $per_page = $request->input('per_page', $this->per_page);
        
        $likes = $stuff->likes()->orderBy('created_at', 'asc')->paginate($per_page);
        
        return $this->response->paginator($likes, new LikeTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {post} /stuffs/:id/dolike 点赞操作
     * @apiVersion 1.0.0
     * @apiName stuff dolike 
     * @apiGroup Stuff
     *
     * @apiParam {Integer} id 分享ID.
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "data": [
     *      "id": 28,
     *       "likeable": {
     *         "id": 1,
     *         "user_id": 1,
     *         "asset": {
     *           "id": 7,
     *           "type": 1,
     *           "filepath": "uploads/images/d80b538b2c3c98cac393a81bb81cf0e9.jpg",
     *           "size": 77465,
     *         },
     *         "content": "开始上传文件",
     *         "tags": "",
     *         "sticked": 1,
     *         "featured": 1,
     *         "view_count": 0,
     *         "like_count": 13,
     *         "comment_count": -2,
     *       },
     *       "user": {
     *         "id": 1,
     *         "username": "xiaobeng",
     *         "summary": null
     *       }
     *  ],
     *  "meta": {
     *    "status": "success",
     *    "code": 200,
     *    "message": "删除成功",
     *  }
     * }
     * @apiErrorExample 错误响应:
     *   {
     *     "meta": {
     *       "message": "操作失败！",
     *       "status_code": 200
     *     }
     *   }
     */
    public function dolike(Request $request, $id)
    {
        $stuff = Stuff::find($id);
        if (!$stuff) {
            throw new ApiExceptions\NotFoundException(404, trans('common.notfound'));
        }
        
        try {
            // 保存关联关系
            $res = $stuff->likes()->create([
                'user_id' => $this->auth_user_id,
            ]);
            
            if ($res) {
                // 喜欢数+1
                $stuff->increment('like_count');
            }
            
        } catch (QueryException $e) {
            Log::warning('Save Like failed: '.$e->getMessage());
            return $this->response->array(ApiHelper::error(trans('common.failed')));
        }
        
        // 返回关联信息
        return $this->response->item($res, new LikeTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {post} /stuffs/:id/cancelike 取消点赞
     * @apiVersion 1.0.0
     * @apiName stuff destory like 
     * @apiGroup Stuff
     *
     * @apiParam {Integer} id 分享Id.
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "meta": {
     *    "status": "success",
     *    "code": 200,
     *    "message": "取消成功",
     *  }
     * }
     */
    public function canceLike(Request $request, $id)
    {
        $like = Like::where(['user_id'=>$this->auth_user_id, 'likeable_id'=>$id, 'likeable_type'=>'Stuff'])->first();
        if (!$like) {
            throw new ApiExceptions\NotFoundException(404, trans('common.notfound'));
        }
        
        if ($like->delete()) {
            // 目标评论数-1
            Stuff::findOrFail($id)->decrement('like_count');
        }
        
        return $this->response->array(ApiHelper::success());
    }
    
}
