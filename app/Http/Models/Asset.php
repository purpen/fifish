<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    /**
     * 关联到模型的数据表
     *
     * @var string
     */
    protected $table = 'assets';
    
    // 头像
    const AVATAR_TYPE = 1;
    
    // 照片
    const PHOTO_TYPE = 9;
    
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
    
    
    /**
     * 在数组中显示的属性
     *
     * @var array
     */
    protected $visible = ['id', 'filepath', 'size'];
    
    
    /**
     * 获取所有拥有的 assetable 模型。
     */
    public function assetable()
    {
        return $this->morphTo();
    }
    
    /**
     * 获取照片的访问Url
     */
    public function viewUrl()
    {
        return config('app.static_url').'/'.$this->filepath;
    }
    
    
}
