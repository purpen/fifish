<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Imageupload;

class Asset extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'assets';
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'target_id', 'type', 'filepath', 'filename', 'size', 'width', 'height', 'mime'];
    
    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = ['state'];
    
    // 头像
    const AVATAR_TYPE = 1;
    
    // 照片
    const PHOTO_TYPE = 9;
    
    /**
     * 获取照片的访问Url
     */
    public function viewUrl()
    {
        return config('app.static_url').'/'.$this->filepath;
    }
    
    /**
     * 照片本地上传
     */
    public function localUpload ($file, $somedata=array())
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
        
        // 保存数据
        $asset = new self();
        $asset->fill($somedata);
        $res = $asset->save();
        
        if ($res) {
            return [
                'id' => $asset->id,
                'asset_url' => config('app.static_url').'/'.$asset->filepath,
            ];
        }
        
        return $res;
    }
    
    
}
