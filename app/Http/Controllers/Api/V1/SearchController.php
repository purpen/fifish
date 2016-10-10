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
use App\Http\Transformers\UserTransformer;

use App\Http\ApiHelper;
use App\Exceptions as ApiExceptions;

use App\Http\Utils\XSUtil;

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
     * @apiParam {Integer} tid  子类型(根据父类型判断条件)：作品：0.所有；1.图片；2.视频；
     * @apiParam {Integer} cid 分类ID
     * @apiParam {Integer} evt 搜索方式：1.内容；2.标签；
     * @apiParam {Integer} sort 排序：0.关联度；1.最新创建；2.最近更新；
     * @apiParam {Integer}  ingore_id 忽略的ID(针对相关搜索，过滤当前内容)
     *
     * @apiSuccessExample 成功响应:
     *   {
     *       "success": true,
     *       "msg": "success",
     *       "total_count": 120,
     *       "total_page": 7,
     *       "data": [
     *           {
     *                 "pid": stuff_6,  // 索引ID
     *                 "oid": 6,    // 原文ID
     *                 "tid": 1,    // 原文类型
     *                 "cid": 3,    // 原文分类ID
     *                 "kind": "Stuff", // 搜索类型：Stuff/User
     *                 "user_id": 20448,
     *                 "tags": [
     *                      "高兴",
     *                      "欢乐",
     *                      "测试"
     *                 ],
     *                 "created_on": 222343434,
     *                 "updated_on": 323424234,
     *                 "stuff": {
     *
     *                 },
     *                 "user": {
     *
     *                 }
     *          },
     *          {
     *              ...
     *          }
     *       ],
     *   }
     */
    public function getList(Request $request)
    {
        $per_page = $request->input('per_page', $this->per_page);
        $page = $request->input('page', 1);
        $str = $request->input('str', null);

        if(empty($str)) return $this->response->array(ApiHelper::error('please input keywork!', 401));

        $type = $request->input('type', 1);
        $str = $request->input('str', null);
        $cid = $request->input('cid', 0);
        $tid = $request->input('tid', 0);
        $evt = $request->input('evt', 1);
        $sort = $request->input('sort', 0);
        $ignore_id = $request->input('ignore_id', 0);

        $options = array(
            'page' => $page,
            'size' => $per_page,
            'type' => $type,
            'cid' => $cid,
            'tid' => $tid,
            'evt' => $evt,
            'sort' => $sort,
            'ingore_id' => $ignore_id,
        );

        $result = XSUtil::search($str, $options);
        if(!$result['success']){
            return $this->response->array(ApiHelper::error('search fail!', 402));
        }

        $stuff_transformer = new StuffTransformer();
        $user_transformer = new UserTransformer();

        foreach($result['data'] as $k=>$v){
            //描述内容过滤
            $result['data'][$k]['content'] = strip_tags($v['high_content'], '<em>');

            $kind = $result['data'][$k]['kind'];
            $cid = (int)$result['data'][$k]['cid'];
            $oid = (int)$result['data'][$k]['oid'];

            $result['data'][$k]['stuff'] = null;
            $result['data'][$k]['user'] = null;

            switch($kind){
                case "Stuff":
                    $stuff = Stuff::find($oid);
                    if(!empty($stuff)){
                        $stuff = $stuff_transformer->transform($stuff);
                        $result['data'][$k]['stuff'] = $stuff;
                    }
                    break;
                case "User":
                    $user = User::find($oid);
                    if(!empty($user)){
                        $user = $user_transformer->transform($user);
                        $result['data'][$k]['user'] = $user;
                    }
                    break;
                default:

            }
        
        }   // endfor

        return $this->response->item($result)->setMeta(ApiHelper::meta());
        //print_r($result['data']);

    }


    /**
     * @api {get} /search/expanded 搜索建议
     * @apiVersion 1.0.0
     * @apiName search expanded
     * @apiGroup Search
     *
     * @apiParam {String} q 搜索内容.
     * @apiParam {Integer} size 数量
     * @apiSuccessExample 成功响应:
     *   {
     *       "data": {
     *          "swords": [
     *              "测试",
     *              "你好"
     *          ]
     *       },
     *   }
     */
    public function getExpanded(Request $request)
    {
        $size = $request->input('size', 8);
        $q = $request->input('q', null);

        if(empty($q)) return $this->response->array(ApiHelper::error('please input keywork!', 401));


        $result = XSUtil::expanded($q, $size);

        if($result['success']){
            return $this->response->item(array('data'=>$result['data']))->setMeta(ApiHelper::meta());
        }else{
            return $this->response->array(ApiHelper::error('search fail!', 402));
        }

    }
    
    
}
