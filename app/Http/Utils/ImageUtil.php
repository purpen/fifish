<?php
    
namespace App\Http\Utils;

use Config;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Imageupload;

class ImageUtil
{
    /**
     * 照片本地上传属性参数
     */
    static public function assetParams ($file, $somedata=array())
    {
        // 图片上传
        $image = Imageupload::upload($file);
        
        // 构建数据        
        $somedata['filepath'] = $image['original_filedir'];
        $somedata['filename'] = $image['original_filename'];
        $somedata['width'] = $image['original_width'];
        $somedata['height'] = $image['original_height'];
        $somedata['size'] = $image['original_filesize'];
        $somedata['mime'] = $image['original_mime'];
        
        return $somedata;
    }
    
    /**
     * 生成文件存储路径
     */
    static public function genStorePath ($prefix='photo')
    {
        return $prefix.'/'.date('ymd').'/'.self::genUniKey();
    }
    
	/**
	 * 云存储 附件URL
	 */
	static public function qiniu_view_url ($key, $style=null)
    {
        // 获取配置参数
        $config = Config::get('filesystems.disks.qiniu'); 
        $domain = $config['domains']['custom'];
        
		$asset_url = $domain.'/'.$key;
		if (!is_null($style)){
			$asset_url .= '-'.$style;
		}
        
		return $asset_url;
	}
    
    /**
     * 生成唯一的Key
     */
    static public function genUniKey ()
    {
        return md5(uniqid());
    }
    
    /**
     * 生成七牛云存储token
     */
    static public function qiniuToken ($isLocal=false)
    {
        // 获取配置参数
        $config = Config::get('filesystems.disks.qiniu'); 
          
        $accessKey = $config['access_key'];
        $secretKey = $config['secret_key'];
        $bucket = $config['bucket'];
                
        $saveKey = '$(x:domain)/'.date('y').'$(mon)$(day)/'.self::genUniKey();
        $persistentOps = 'avthumb/imageView/1/w/580/h/580/q/85|avthumb/imageView/1/w/160/h/120/q/90';
        
        $policy = array(
            'deadline'      => time() + 36000,
            'saveKey'       => $saveKey,
            'callbackUrl'   => $config['notify_url'],
            'callbackBody'  => '{"filename":"$(fname)", "filepath":"$(key)", "size":"$(fsize)", "width":"$(imageInfo.width)", "height":"$(imageInfo.height)","mime":"$(mimeType)","hash":"$(etag)","desc":"$(x:desc)","parent_id":"$(x:parent_id)","type":"$(x:type)", "user_id":"$(x:user_id)"}',
            'persistentOps' => $persistentOps,
        );
        foreach ($policy as $k => $v) {
            if ($v === null) unset($policy[$k]);
        }
        // 生成上传Token
        $auth = new Auth($accessKey, $secretKey);
        
        // 直接上传还是本地上传
        if (!$isLocal) {
            return $auth->uploadToken($bucket, null, 3600, $policy);
        } else {
            return $auth->uploadToken($bucket);
        }
    }
    
}