<?php

namespace App\Http\Controllers\Api\V1;

use Config;
use Storage;
use Illuminate\Http\Request;

use App\Http\ApiHelper;
use App\Http\Models\Asset;
use App\Exceptions as ApiExceptions;
use App\Http\Utils\ImageUtil;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Imageupload;

class UploadController extends BaseController
{
    /**
     * @api {get} /upload/qiniuback 七牛云上传回调地址
     * @apiVersion 1.0.0
     * @apiName upload asset
     * @apiGroup Upload
     *
     */
    public function qiniuback(Resquest $request)
    {
        $result = [];
        
        $asset = new Asset();
        $asset->fill($request->all());
        $res = $asset->save();
       
        if ($res) {
            $result['link'] = ImageUtil::qiniu_view_url($asset->filepath);
        }
       
        return $this->response->array(ApiHelper::success(trans('common.success'), 200, $result));
    }
    
    /**
     * @api {get} /upload/qiniuToken 获取七牛云上传token
     * @apiVersion 1.0.0
     * @apiName upload token
     * @apiGroup Upload
     *
     * @apiSuccessExample 成功响应:
     *   {
     *       "meta": {
     *         "message": "request ok",
     *         "status_code": 200
     *       },
     *       "data": {
     *           "qiniu_token": "lg_vCeWWdlVmlld1wvMVwvd1wvMTY.......wXC9oXC8xMjBcL3DkyMn0="
     *         }
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
    public function qiniuToken()
    {
        // 生成上传Token
        $token = ImageUtil::qiniuToken();
        
        return $this->response->array(ApiHelper::success(trans('common.success'), 200, array('qiniu_token' => $token)));
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
        $file = $request->file('file');
        if (!$file->isValid()) {
            throw new ApiExceptions\ValidationException('Not Found!', []);
        }
        
        $result = $this->upload_handle($file, $request->input('target_id', 0), Asset::PHOTO_TYPE);
        
        return $this->response->array(ApiHelper::success(trans('common.success'), 200, $result));
    }
    
    /**
     * @api {post} /upload/avatar 更新用户头像
     * @apiVersion 1.0.0
     * @apiName user avatar
     * @apiGroup User
     *
     * @apiParam {string} file 上传文件
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
    public function avatar(Request $request, $id)
    {
        $file = $request->file('avatar');
        if (!$file->isValid()) {
            return $this->response->array(ApiHelper::error('File is invalid!', 401));
        }
        
        $result = $this->upload_handle($file, $request->input('user_id', 0), Asset::AVATAR_TYPE);
        
        return $this->response->array(ApiHelper::success('upload ok!', 200, $result));
    }
    
    /**
     * 附件上传
     */
    protected function upload_handle($file, $target_id, $type)
    {
        // 图片上传
        $image = Imageupload::upload($file);
        
        // 构建数据
        $somedata = [];
        
        $somedata['user_id'] = $this->auth_user_id;
        $somedata['target_id'] = $target_id;
        $somedata['type'] = $type;
        
        $somedata['filepath'] = $image['original_filedir'];
        $somedata['filename'] = $image['original_filename'];
        $somedata['width'] = $image['original_width'];
        $somedata['height'] = $image['original_height'];
        $somedata['size'] = $image['original_filesize'];
        $somedata['mime'] = $image['original_mime'];
        
        // 保存数据
        $asset = new Asset();
        $asset->fill($somedata);
        $res = $asset->save();
        
        if ($res) {
            $imageUrl = config('app.static_url').'/'.$somedata['filepath'];
        }
        
        return [
          'imageUrl' => $imageUrl
        ];
    }
    
    
}
