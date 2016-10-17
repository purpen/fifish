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
     *       "id": 200,
     *       "file": {
     *           "srcfile":"http://clouddn.com/photo/160926/cbbd34cc77e73f06abbcc86cecfdd8b0",
     *           "large": "http://clouddn.com/photo/160926/cbbd34cc77e73f06abbcc86cecfdd8b0!cvxlg",
     *           "small": "http://clouddn.com/photo/160926/cbbd34cc77e73f06abbcc86cecfdd8b0!cvxsm"
     *       },
     *       "ret": "success"
     *   }
     * @apiErrorExample 失败响应:
     * {
     *   // 空数组
     * }
     */
    public function qiniuback(Request $request)
    {
        $result = [];
        
        $param = file_get_contents('php://input');
        
        Log::warning($param);
        
        $body = json_decode($param, true);
        
        // urldecode
        foreach($body as $key=>$value) {
            if (in_array($key, array('filepath','mime'))) {
                $body[$key] = urldecode($value);
            }
        }
        
        // save asset
        $asset = new Asset();
        $asset->fill($body);
        $res = $asset->save();
       
        if ($res) {
            $result['id'] = $asset->id;
            $result['ret'] = 'success';
            $result['file'] = $asset->file;
        }
       
        return $this->response->array($result);
    }
    
    /**
     * 异步处理通知
     */
    public function qiniuNotify(Request $request)
    {
        Log::warning('Qiniu Notify!!!');
    }
    
    /**
     * @api {get} /upload/photoToken 获取上传照片Token
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
     *           "token": "lg_vCeWWdlVmlld1wvMVwvd1wvMTY.......wXC9oXC8xMjBcL3DkyMn0=",
     *           "upload_url": "http://up.qiniu.com",
     *       }
     *   }
     */
    public function photoToken(Request $request)
    {
        $assetable_id = 0;
        $assetable_type = 'Stuff';
        $store_prefix = 'photo';
        
        return $this->upToken(false, $store_prefix, $assetable_id, $assetable_type);
    }
    
    /**
     * @api {get} /upload/videoToken 获取上传视频Token
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
     *           "token": "lg_vCeWWdlVmlld1wvMVwvd1wvMTY.......wXC9oXC8xMjBcL3DkyMn0=",
     *           "upload_url": "http://up.qiniu.com",
     *       }
     *   }
     */
    public function videoToken(Request $request)
    {   
        $assetable_id = 0;
        $assetable_type = 'Stuff';
        $store_prefix = 'video';
        
        return $this->upToken(false, $store_prefix, $assetable_id, $assetable_type, 2);
    }
    
    /**
     * @api {get} /upload/avatarToken 获取上传头像Token
     * @apiVersion 1.0.0
     * @apiName upload avatar
     * @apiGroup Upload
     * 
     * @apiSuccessExample 成功响应:
     *   {
     *       "meta": {
     *         "message": "request ok",
     *         "status_code": 200
     *       },
     *       "data": {
     *           "token": "lg_vCeWWdlVmlld1wvMVwvd1wvMTY.......wXC9oXC8xMjBcL3DkyMn0=",
     *           "upload_url": "http://up.qiniu.com",
     *       }
     *   }
     */
    public function avatarToken(Request $request)
    {
        $assetable_id = $this->auth_user_id;
        $assetable_type = 'User';
        $store_prefix = 'avatar';
        
        return $this->upToken(false, $store_prefix, $assetable_id, $assetable_type);
    }
    
    /**
     * 获取七牛上传token
     */
    protected function upToken($is_local=false, $store_prefix='photo', $assetable_id=0, $assetable_type='Stuff',$kind=1){
        $upload_url = Config::get('filesystems.disks.qiniu.upload_url');
        
        // 生成上传Token
        $token = ImageUtil::qiniuToken($is_local, $store_prefix, $assetable_id, $assetable_type, $this->auth_user_id, $kind);
        
        return $this->response->array(ApiHelper::success(trans('common.success'), 200, array(
            'token' => $token, 
            'upload_url' => $upload_url,
        )));
    }
    
    /**
     * @api {get} /upload/qiniuToken 获取云上传token(七牛)
     * @apiVersion 1.0.0
     * @apiName upload token
     * @apiGroup Upload
     *
     * @apiParam {String} assetable_type (头像：User, 分享：Stuff)
     *
     * @apiSuccessExample 成功响应:
     *   {
     *       "meta": {
     *         "message": "request ok",
     *         "status_code": 200
     *       },
     *       "data": {
     *           "token": "lg_vCeWWdlVmlld1wvMVwvd1wvMTY.......wXC9oXC8xMjBcL3DkyMn0=",
     *           "upload_url": "http://up.qiniu.com", // 图片云上传地址
     *       }
     *   }
     *
     */
    public function qiniuToken(Request $request, $assetable_type='Stuff')
    {   
        $assetable_id = 0;
        $store_prefix = 'photo';
        
        if ($assetable_type == 'User') {
            $store_prefix = 'avatar';
            $assetable_id = $this->auth_user_id;
        }
        
        $upload_url = Config::get('filesystems.disks.qiniu.upload_url');
        
        // 生成上传Token
        $token = ImageUtil::qiniuToken(false, $store_prefix, $assetable_id, $assetable_type, $this->auth_user_id);
        
        return $this->response->array(ApiHelper::success(trans('common.success'), 200, array(
            'token' => $token, 
            'upload_url' => $upload_url,
        )));
    }
    
}
