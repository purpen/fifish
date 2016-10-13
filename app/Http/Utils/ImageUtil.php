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
     * 云存储 (服务端上传)
     */
    static public function storeQiniuCloud($filepath, $save_dir='photo', $assetable_id=0, $assetable_type='Stuff', $user_id=0)
    {
        // 生成上传Token
        $uptoken = self::qiniuToken(false, $save_dir, $assetable_id, $assetable_type, $user_id);
        
        // 初始化UploadManager对象并进行文件的上传
        $uploadManager = new UploadManager();
        
        // 文件上传
        list($ret, $err) = $uploadManager->putFile($uptoken, null, $filepath);
        
        return $ret;
    }
    
    /**
     * 生成七牛云存储token
     */
    static public function qiniuToken ($is_local=false, $save_dir='photo', $assetable_id=0, $assetable_type='Stuff', $user_id=0)
    {
        // 获取配置参数
        $config = Config::get('filesystems.disks.qiniu'); 
          
        $accessKey = $config['access_key'];
        $secretKey = $config['secret_key'];
        $bucket = $config['bucket'];
                
        $saveKey = $save_dir.'/'.date('ymd').'/'.self::genUniKey().'$(ext)';
        if ($assetable_type == 'User') {
            $persistentOps = 'imageView2/1/w/180/h/180/interlace/1/q/100|imageView2/1/w/50/h/50/interlace/1/q/100';
        } else {
            $persistentOps = 'imageView2/1/w/480/h/270/interlace/1/q/90|imageView2/1/w/120/h/67/interlace/1/q/100';
        }
        
        $policy = array(
            'deadline'      => time() + 36000,
            'saveKey'       => $saveKey,
            'callbackUrl'   => $config['notify_url'],
            'callbackBody'  => '{"filename":"$(fname)", "filepath":"$(key)", "size":"$(fsize)", "width":"$(imageInfo.width)", "height":"$(imageInfo.height)","mime":"$(mimeType)","hash":"$(etag)","desc":"$(x:desc)","assetable_id":'.$assetable_id.',"assetable_type":"'.$assetable_type.'", "user_id":'.$user_id.'}',
            'persistentOps' => $persistentOps,
        );
        
        foreach ($policy as $k => $v) {
            if ($v === null) unset($policy[$k]);
        }
        // 生成上传Token
        $auth = new Auth($accessKey, $secretKey);
        
        // 直接上传还是本地上传
        if (!$is_local) {
            return $auth->uploadToken($bucket, null, 3600, $policy);
        } else {
            return $auth->uploadToken($bucket);
        }
    }
    
	/**
	 * 云存储 附件URL
	 */
	static public function qiniuViewUrl($key, $style=null)
    {
        // 获取配置参数
        $config = Config::get('filesystems.disks.qiniu'); 
        $domain = $config['domains']['custom'];
        
		$asset_url = $domain.'/'.$key;
		if (!is_null($style)){
			$asset_url .= '!'.$style;
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
     * 生成文件存储路径
     */
    static public function genStorePath ($prefix='photo')
    {
        return $prefix.'/'.date('ymd').'/'.self::genUniKey();
    }
    
}