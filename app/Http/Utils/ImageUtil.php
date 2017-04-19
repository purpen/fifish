<?php
    
namespace App\Http\Utils;

use Config;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Imageupload;
use Log;

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
    static public function storeFileQiniu($filepath, $save_dir='photo', $assetable_id=0, $assetable_type='Stuff', $user_id=0)
    {
        // 生成上传Token
        $uptoken = self::qiniuToken(false, $save_dir, $assetable_id, $assetable_type, $user_id);
        
        // 初始化UploadManager对象并进行文件的上传
        $uploadManager = new UploadManager();
        
        // 文件上传
        list($ret, $err) = $uploadManager->putFile($uptoken, null, $filepath);
        
        if ($err !== null) {
            var_dump($err);
        }
        
        return $ret;
    }
    
    /**
     * 存储内容到七牛云
     */
    static public function storeContentQiniu($content, $save_dir='photo', $assetable_id=0, $assetable_type='Stuff', $user_id=0)
    {
        // 生成上传Token
        $uptoken = self::qiniuToken(false, $save_dir, $assetable_id, $assetable_type, $user_id);
        
        // 初始化UploadManager对象并进行文件的上传
        $uploadManager = new UploadManager();
                
        // 文件上传
        list($ret, $err) = $uploadManager->put($uptoken, null, $content);
        
        if ($err !== null) {
            var_dump($err);
        }
        
        return $ret;
    }
    
    /**
     * 生成七牛云存储token
     */
    static public function qiniuToken ($is_local=false, $save_dir='photo', $assetable_id=0, $assetable_type='Stuff', $user_id=0, $kind=1)
    {
        // 获取配置参数
        $config = Config::get('filesystems.disks.qiniu'); 
          
        $accessKey = $config['access_key'];
        $secretKey = $config['secret_key'];
        $bucket = $config['bucket'];
        
        $file_path = $save_dir.'/'.date('ymd').'/'.self::genUniKey();
                
        $saveKey = $file_path.'$(ext)';
        
        $persistentOps = '';
        if ($save_dir == 'video') {
            // 水印图片：http://oe5tkubcj.bkt.clouddn.com/water@2x.png
            $water_image = 'aHR0cDovL29lNXRrdWJjai5ia3QuY2xvdWRkbi5jb20vd2F0ZXJAMngucG5n';
            
            Log::warning('saveas:'.$bucket.':'.$file_path.'-wm.mp4');
            
            $saveas = self::urlsafe_base64_encode($bucket.':'.$file_path.'-wm.mp4');
            $persistentOps = 'vframe/jpg/offset/1|imageView2/1/w/480/h/270/interlace/1/q/100|watermark/1/image/aHR0cDovL29lNXRrdWJjai5ia3QuY2xvdWRkbi5jb20vd2F0ZXJAMngucG5n/dissolve/70/gravity/SouthWest/dx/20/dy/20;vframe/jpg/offset/1|imageView2/1/w/120/h/67/interlace/1/q/100;avthumb/mp4/wmImage/'.$water_image.'/wmGravity/SouthWest/wmOffsetX/20/wmOffsetY/-20|saveas/'.$saveas;
        }
        
        Log::warning('persistentOps:'.$persistentOps);
        
        $policy = array(
            'deadline'      => time() + 36000,
            'saveKey'       => $saveKey,
            'callbackUrl'   => $config['notify_url'],
            'callbackBody'  => '{"persistentId":"$(persistentId)", "filename":"$(fname)", "filepath":"$(key)", "size":"$(fsize)", "width":"$(imageInfo.width)", "height":"$(imageInfo.height)","mime":"$(mimeType)","duration":"$(avinfo.video.duration)","vbyte":"$(avinfo.format.size)","hash":"$(etag)","desc":"$(x:desc)","assetable_id":'.$assetable_id.',"assetable_type":"'.$assetable_type.'", "kind":'.$kind.',"user_id":'.$user_id.'}',
            'persistentOps' => $persistentOps,
            'persistentNotifyUrl' => $config['persistent_url'],
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
     * 删除七牛文件
     */
    static public function deleteQiniuFile($key)
    {
        // 获取配置参数
        $config = Config::get('filesystems.disks.qiniu'); 
          
        $accessKey = $config['access_key'];
        $secretKey = $config['secret_key'];
        $bucket = $config['bucket'];
        
        // 初始化Auth状态
        $auth = new Auth($accessKey, $secretKey);

        // 初始化BucketManager
        $bucketMgr = new BucketManager($auth);

        // 删除$bucket 中的文件 $key
        $err = $bucketMgr->delete($bucket, $key);
        
        if ($err !== null) {
            Log::debug('delete $key ====> '.var_dump($err));
            return false;
        } else {
            return true;
        }
    }
    
    /**
     * 对字符串urlsafe base64编码
     */
    static public function urlsafe_base64_encode($str)
    {
        $find = array('+', '/');
        $replace = array('-', '_');
        
        return str_replace($find, $replace, base64_encode($str));
    }
    
	/**
	 * 云存储 附件URL
	 */
	static public function qiniuViewUrl($key, $style=null)
    {
        // 获取配置参数
        $config = Config::get('filesystems.disks.qiniu'); 
        $domain = $config['domains']['https'];
        
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