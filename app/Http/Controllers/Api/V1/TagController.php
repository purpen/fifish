<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;

use Validator;
use App\Http\Models\Tag;
use App\Http\Utils\ImageUtil;
use App\Http\Transformers\TagTransformer;

class TagController extends BaseController
{
    /**
     * @api {get} /tags 获取标签列表
     * @apiVersion 1.0.0
     * @apiName tag list 
     * @apiGroup Tag
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "data": [
     *    {
     *         "id": 1,
     *        "name": "科技2",
     *         "display_name": "科技范"
     *          "cover": {
     *              "id": 145,
     *              "filepath": "photo/161018/c9dc008d403eae0e33b4a97eb8412c0f.jpg",
     *              "size": 112537,
     *              "width": 1248,
     *              "height": 896,
     *              "duration": 0,
     *              "kind": 1,
     *              "file": {
     *                "srcfile": "http://clouddn.com/photo/161018/c9dc008d403eae0e33b4a97eb8412c0f.jpg",
     *                 "small": "http://clouddn.com/..../403eae0e33b4a97eb8412c0f.jpg!cvxsm",
     *                "large": "http://bkt.clouddn.com/.../403eae0e33b4a97eb8412c0f.jpg!cvxlg",
     *                 "thumb": "http://clouddn.com/.../403eae0e33b4a97eb8412c0f.jpg!psq"
     *                }
     *     }
     *
     *  ],
     *  "meta": {
     *    "status": "success",
     *    "code": 200,
     *    "message": "Success.",
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
    public function getList(Request $request)
    {
        $per_page = $request->input('per_page', $this->per_page);
        
        $tags = Tag::orderBy('created_at', 'desc')->paginate($per_page);
        
        return $this->response->paginator($tags, new TagTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {get} /tags/sticks 获取推荐标签列表
     * @apiVersion 1.0.0
     * @apiName tag stick list 
     * @apiGroup Tag
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "data": [
     *    {
     *         "id": 1,
     *        "name": "科技2",
     *         "display_name": "科技范"
     *          "cover": {
     *              "id": 145,
     *              "filepath": "photo/161018/c9dc008d403eae0e33b4a97eb8412c0f.jpg",
     *              "size": 112537,
     *              "width": 1248,
     *              "height": 896,
     *              "duration": 0,
     *              "kind": 1,
     *              "file": {
     *                "srcfile": "http://clouddn.com/photo/161018/c9dc008d403eae0e33b4a97eb8412c0f.jpg",
     *                 "small": "http://clouddn.com/..../403eae0e33b4a97eb8412c0f.jpg!cvxsm",
     *                "large": "http://bkt.clouddn.com/.../403eae0e33b4a97eb8412c0f.jpg!cvxlg",
     *                 "thumb": "http://clouddn.com/.../403eae0e33b4a97eb8412c0f.jpg!psq"
     *                }
     *     }
     *
     *  ],
     *  "meta": {
     *    "status": "success",
     *    "code": 200,
     *    "message": "Success.",
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
    public function stickList(Request $request)
    {
        $per_page = $request->input('per_page', $this->per_page);
        
        $tags = Tag::sticked()->orderBy('sticked_at', 'desc')->paginate($per_page);
        
        return $this->response->paginator($tags, new TagTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {put} /tags/store 新增标签
     * @apiVersion 1.0.0
     * @apiName tag store 
     * @apiGroup Tag
     *
     * @apiParam {string} name 标签名称.
     * @apiParam {string} display_name 标签显示名称
     * @apiParam {string} description 标签说明 （optional）
     * @apiParam {File} file 封面图图片
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "meta": {
     *    "code": 200,
     *    "message": "Success.",
     *  }
     * }
     */
    public function store(Request $request)
    {
        $check = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:30'],
            'display_name' => ['required', 'min:2', 'max: 255'],
        ]);
        if ($check->fails()) {
            throw new ApiExceptions\ValidationException(trans('common.validate'), $check->errors());
        }
        
        $insert = $request->only(['name', 'display_name']);
        $insert['description'] = $request->input('description');
        
        $tag = Tag::create($insert);
        if (!$tag) {
            return $this->response->array(ApiHelper::error(trans('common.failed'), 501));
        }
        
        // 保存封面图
        $file = $request->file('file');
        if ($file) {
            $somedata = ImageUtil::assetParams($file, array(
                'user_id' => $this->auth_user_id
            ));
            $assetInfo = $tag->assets()->create($somedata);
        }
        
        return $this->response->item($tag, new TagTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {put} /tags/{id}/update 更新标签
     * @apiVersion 1.0.0
     * @apiName tag update 
     * @apiGroup Tag
     *
     * @apiParam {string} name 标签名称.
     * @apiParam {string} display_name 标签显示名称
     * @apiParam {string} description 标签说明 （optional）
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
        $check = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:30'],
            'display_name' => ['required', 'min:2', 'max: 255'],
        ]);
        if ($check->fails()) {
            throw new ApiExceptions\ValidationException(trans('common.validate'), $check->errors());
        }
        
        $tag = Tag::findOrFail($id);
        $res = $tag->update($request->all());
    
        if (!$res) {
            return $this->response->array(ApiHelper::error(trans('common.failed'), 501));
        }
        
        return $this->response->item($tag, new TagTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {put} /tags/{id}/upStick 推荐标签
     * @apiVersion 1.0.0
     * @apiName tag upStick 
     * @apiGroup Tag
     *
     * @apiParam {Integer} id 标签ID.
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "meta": {
     *    "code": 200,
     *    "message": "Success.",
     *  }
     * }
     */
    public function upStick(Request $request, $id)
    {
        $res = Tag::upStick($id);
        if (!$res) {
            return $this->response->array(ApiHelper::error(trans('common.failed'), 501));
        }
        
        return $this->response->array(ApiHelper::success());
    }
    
    
    /**
     * @api {post} /tags/:id/destory 删除标签
     * @apiVersion 1.0.0
     * @apiName tag destory 
     * @apiGroup Tag
     *
     * @apiParam {Integer} id 标签ID.
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "meta": {
     *    "code": 200,
     *    "message": "Success.",
     *  }
     * }
     */
    public function destory($id)
    {
        $tag = Tag::findOrFail($id);
        
        // 检测是否有关联分享内容
        if (count($tag->stuffs->toArray())) {
            throw new ApiExceptions\ValidationException(trans('common.not_allow'), []);
        }
        
        // 执行删除操作
        $res = $tag->delete();
        
        return $this->response->array(ApiHelper::success());
    }

}
