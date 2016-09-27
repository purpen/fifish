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
use App\Http\Transformers\StuffTransformer;

use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;

class SearchController extends BaseController
{   
    /**
     * @api {get} /search/list 获取搜索列表
     * @apiVersion 1.0.0
     * @apiName search list 
     * @apiGroup Search
     *
     * @apiParam {Integer} page 当前分页.
     * @apiParam {Integer} per_page 每页数量
     * @apiParam {String} str 内容
     * @apiParam {Integer} type 类型：1.作品；2.用户；3.－－；
     * @apiParam {Integer} cid 子类型(根据父类型判断条件)：作品：1.图片；2.视频；
     * @apiParam {Integer} evt 搜索方式：1.内容；2.标签；
     * @apiParam {Integer} sort 排序：0.关联度；1.最新创建；2.最近更新；
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
        $type = $request->input('type', 1);
        $str = $request->input('str', null);
        $cid = $request->input('cid', 0);
        $evt = $request->input('evt', 1);
        $sort = $request->input('sort', 0);

        $query = array();

    }
    
    
}
