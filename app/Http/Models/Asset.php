<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{    
    /**
     * 关联到模型的数据表
     *
     *  Schema: assets
     *      id,
     *      assetable_id,
     *      assetable_type,
     *      filepath,
     *      filename,
     *      size,width,height,mime
     *      state,created_at,updated_at
     *
     * @var string
     */
    protected $table = 'assets';
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'filepath', 'filename', 'size', 'width', 'height', 'mime'];
    
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
    protected $visible = ['id', 'filepath', 'size', 'width', 'height'];
    
    /**
     * 获取所有拥有的 assetable 模型。
     */
    public function assetable()
    {
        return $this->morphTo();
    }
    
    /**
     * 获取照片/视频截图访问fileurl
     */
    public function getFileurlAttribute()
    {
        return config('app.static_url').'/'.$this->filepath;
    }
    
}
