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
    
    // 图片
    const PHOTO_TYPE = 9;
    
    
}
