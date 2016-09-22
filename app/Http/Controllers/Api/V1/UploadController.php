<?php

namespace App\Http\Controllers\Api\V1;

use Config;
use Storage;
use Illuminate\Http\Request;
use Log;

use App\Http\ApiHelper;
use App\Http\Models\User;
use App\Http\Models\Asset;
use App\Http\Utils\ImageUtil;
use App\Exceptions as ApiExceptions;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class UploadController extends BaseController
{
    /**
     * @api {get} /upload/qiniuback 云上传回调地址(七牛)
     * @apiVersion 1.0.0
     * @apiName upload asset
     * @apiGroup Upload
     *
     * @apiSuccessExample 成功响应:
     *   {
     *       "meta": {
     *         "message": "request ok",
     *         "status_code": 200
     *       },
     *       "data": {
     *           "imageUrl": "http://xxxx.com/uploads/images/ada22917f864829d4ef2a7be17a2fcdb.jpg"
     *       }
     *   }
     */
    public function qiniuback(Request $request)
    {
        $result = [];
        
        $param = file_get_contents('php://input');
        $body = json_decode($param, true);
        
        Log::warning(var_dump($body));
        
        // urldecode
        // for($i=0;$i<count($body);$i++){
//             $body[$i] = ApiHelper::urlsafe_b64decode($body[$i]);
//         }
        
        // save asset
        $asset = new Asset();
        $asset->fill($body);
        $res = $asset->save();
       
        if ($res) {
            $result['ret'] = 'success';
            $result['link'] = ImageUtil::qiniu_view_url($asset->filepath);
        }
       
        return $this->response->array($result);
    }
    
    /**
     * @api {get} /upload/qiniuToken 获取云上传token(七牛)
     * @apiVersion 1.0.0
     * @apiName upload token
     * @apiGroup Upload
     *
     * @apiParam {String} domain (optional) 上传类型（照片：photo,头像：avatar）.
     *
     * @apiSuccessExample 成功响应:
     *   {
     *       "meta": {
     *         "message": "request ok",
     *         "status_code": 200
     *       },
     *       "data": {
     *           "token": "lg_vCeWWdlVmlld1wvMVwvd1wvMTY.......wXC9oXC8xMjBcL3DkyMn0=",
     *            "domain": "photo",
     *            "upload_url": "http://up.qiniu.com",
     *         }
     *   }
     *
     */
    public function qiniuToken(Request $request)
    {
        // 生成上传Token
        $token = ImageUtil::qiniuToken();
        
        $domain = $request->input('domain', 'photo');
        $upload_url = Config::get('filesystems.disks.qiniu.upload_url');
        
        return $this->response->array(ApiHelper::success(trans('common.success'), 200, array(
            'token' => $token, 
            'domain' => $domain,
            'upload_url' => $upload_url,
        )));
    }
    
    /**
     * @api {get} /upload/photo 本地上传照片
     * @apiVersion 1.0.0
     * @apiName upload photo
     * @apiGroup Upload
     *
     * @apiSuccessExample 成功响应:
     *   {
     *       "meta": {
     *         "message": "request ok",
     *         "status_code": 200
     *       },
     *       "data": {
     *           "imageUrl": "http://xxxx.com/uploads/images/ada22917f864829d4ef2a7be17a2fcdb.jpg"
     *       }
     *   }
     *
     * @apiErrorExample 错误响应:
     *   {
     *     "meta": {
     *       "message": "Not Found！",
     *       "status_code": 404
     *     }
     *   }
     */
    public function photo(Request $request)
    {
        
    }
    
    /**
     * @api {get} /upload/video 本地上传视频
     * @apiVersion 1.0.0
     * @apiName upload video
     * @apiGroup Upload
     *
     * @apiSuccessExample 成功响应:
     *   {
     *       "meta": {
     *         "message": "request ok",
     *         "status_code": 200
     *       },
     *       "data": {
     *           "imageUrl": "http://xxxx.com/uploads/images/ada22917f864829d4ef2a7be17a2fcdb.jpg"
     *       }
     *   }
     *
     * @apiErrorExample 错误响应:
     *   {
     *     "meta": {
     *       "message": "Not Found！",
     *       "status_code": 404
     *     }
     *   }
     */
    public function video(Request $request)
    {   
        
    }
    
    /**
     * @api {post} /upload/avatar 更新用户头像
     * @apiVersion 1.0.0
     * @apiName upload avatar
     * @apiGroup Upload
     *
     * @apiParam {File} avatar 上传文件
     * 
     * @apiSuccessExample 成功响应:
     *   {
     *       "meta": {
     *         "message": "request ok",
     *         "status_code": 200
     *       },
     *       "data": {
     *           "imageUrl": "http://xxxx.com/uploads/images/ada22917f864829d4ef2a7be17a2fcdb.jpg"
     *       }
     *   }
     *
     * @apiErrorExample 错误响应:
     *   {
     *     "meta": {
     *       "message": "Not Found！",
     *       "status_code": 404
     *     }
     *   }
     */
    public function avatar(Request $request)
    {
        $file = $request->file('avatar');
        if (empty($file) || !$file->isValid()) {
            return $this->response->array(ApiHelper::error('File is invalid!', 401));
        }
        
        $user = User::find($this->auth_user_id);
        if (!$user) {
            throw new ApiExceptions\NotFoundException(404, trans('common.notfound'));
        }
        $result = [];
        $somedata = ImageUtil::assetParams($file, array(
            'user_id' => $this->auth_user_id
        ));
        $res = $user->assets()->create($somedata);
        if ($res) {
            $result = [
                'id' => $res->id,
                'asset_url' => config('app.static_url').'/'.$res->filepath,
            ];
        }
        
        return $this->response->array(ApiHelper::success(trans('common.upload_ok'), 200, $result));
    }
    
}
