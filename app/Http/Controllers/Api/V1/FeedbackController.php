<?php
/**
 * 意见反馈
 *
 * @author purpen
 */
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Models\Feedback;
use App\Http\Transformers\FeedbackTransformer;
use App\Http\ApiHelper;

use Validator;

class FeedbackController extends BaseController
{
    /**
     * @api {get} /feedback/:state 获取列表
     * @apiVersion 1.0.0
     * @apiName feedback list 
     * @apiGroup Feedback
     *
     * @apiParam {Integer} state 反馈信息处理状态.
     *
     * @apiSuccessExample 成功响应:
     * {
     *  "data": [
     *    {
     *      "contact": "18610320751",
     *      "content": "这是2个意见反馈！！！"
     *    },
     *    {
     *      "contact": "18610320751",
     *      "content": "这是一个意见反馈！！！"
     *    }
     *  ],
     *  "meta": {
     *    "status": "success",
     *    "code": 200,
     *    "message": "获取反馈信息列表成功",
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
    public function getList ($state=0)
    {
        $state = (int)$state;
        if ($state != 0) {
            $feedbacks = Feedback::where('state', $state)->orderBy('created_at', 'desc')->paginate(20);
            return $this->response->paginator($feedbacks, new FeedbackTransformer());
        } else {
            $feedbacks = Feedback::orderBy('created_at', 'desc')->paginate(20);
            return $this->response->paginator($feedbacks, new FeedbackTransformer());
        }
    }
    
    /**
     * @api {post} /feedback/submit 提交信息
     * @apiVersion 1.0.0
     * @apiName feedback submit
     * @apiGroup Feedback
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
     * {
     *   "meta": {
     *      "message": "提交反馈信息失败",
     *      "status_code": 404
     *   }
     * }
     */
    public function submited (Request $request)
    {
        $check = Validator::make($request->all(), [
            'contact' => ['required'],
            'content' => ['required', 'min:2', 'max:1500']
        ]);
        if ($check->fails()) {
            throw new ApiExceptions\ValidationException(trans('common.validate'), $check->errors());
        }
        
        $feedback = Feedback::create($request->only(['contact', 'content'])); 
        if (!$feedback) {
            return $this->response->array(ApiHelper::error(trans('common.failed'), 501));
        }
        
        return $this->response->item($feedback, new FeedbackTransformer())->setMeta(ApiHelper::meta());
    }
    
    /**
     * @api {put} /feedback/finfished/:id 更新完成状态
     * @apiVersion 1.0.0
     * @apiName feedback finfished
     * @apiGroup Feedback
     *
     * @apiParam {integer} id 反馈信息Id
     *
     * @apiSuccessExample 成功响应:
     *   {
     *     "status": "success",
     *     "code": 200,
     *     "message": "操作成功",
     *     "data": []
     *   }
     */
    public function finfished ($id)
    {
        $state = Feedback::STATE_FINFISHED;
        return $this->updateState($id, $state);
    }
    
    /**
     * 更新反馈信息的状态
     * @param tinyInt $state
     */
    protected function updateState ($id, $state = 1)
    {
        $feedback = Feedback::find($id);
        $feedback->state = (int)$state;
        $ok = $feedback->save();
        
        if ($ok) {
            return $this->response->array(ApiHelper::success());
        } else {
            return $this->response->error('操作失败', 501);
        }
        
    }
}
