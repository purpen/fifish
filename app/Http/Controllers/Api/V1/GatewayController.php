<?php

namespace App\Http\Controllers\Api\V1;

use Log;
use Illuminate\Http\Request;
use Dingo\Api\Exception as DingoException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\QueryException;

use App\Http\Models\User;
use App\Http\Models\Asset;
use App\Http\Models\Column;
use App\Http\Models\ColumnSpace;
use App\Http\Transformers\ColumnTransformer;
use App\Http\Transformers\ColumnSpaceTransformer;

use App\Http\ApiHelper;
use App\Http\Utils\ImageUtil;
use App\Exceptions as ApiExceptions;

class GatewayController extends BaseController
{   
    /**
     * @api {get} /columns 栏目列表
     * @apiVersion 1.0.0
     * @apiName column list 
     * @apiGroup Gateway
     *
     * @apiParam {Integer} page 当前分页.
     * @apiParam {Integer} per_page 每页数量
     * @apiParam {Integer} name 栏目位名称
     *
     * @apiSuccessExample 成功响应:
     *   {
     *       "data": [
     *           {
     *                 "id": 6,
     *                 "content": "开始上传一个图片",
     *                 "user_id": 1,
     *                 "column_space_id": 12,   // 所在栏目位ID
     *                 "type": 1,   // 位置：1.官网；2.APP；
     *                 "title": "这是标题",
     *                 "sub_title", "这是子标题",
     *                 "content": "这是内容",
     *                 "evt": 1,
     *                 "url": "23",   // 链接或跳转ID(用于app)：1.url；2.stuff详情；3.个人主页；4.－－；
     *                 "cover_id": 123,
     *                 "cover": {
     *                   "id": 7,
     *                   "size": "105k",
     *                   "width": 1000,
     *                   "height": 1000,
     *                   "fileurl": "http://static.fifish.me/uploads/images/a1bdbee1ffd2c058d3a26b4a397e6b5a.jpg"
     *                 },
     *                 "status": 1, // 状态：0.不显示；1.显示； 
     *                 "order": 100, // 排序(从大到小)
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
    public function columnList(Request $request)
    {
        $per_page = $request->input('per_page', $this->per_page);
        $name = $request->input('name', '');

        if(empty($name)){
            return $this->response->array(ApiHelper::error('缺少请求参数!', 401));
        }

        $column_space = ColumnSpace::where('name', $name)->first();
        if(!$column_space){
            throw new ApiExceptions\NotFoundException(404, trans('栏目位不存在或已删除!'));
        }

        $query = array();
        $query['column_space_id'] = $column_space->id;
        $query['status'] = 1;
        
        $columns = Column::where($query)->orderBy('order', 'desc')->orderBy('created_at', 'desc')->paginate($per_page);
        
        return $this->response->paginator($columns, new ColumnTransformer())->setMeta(ApiHelper::meta());
    }
    
    

    
}
