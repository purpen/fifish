<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    /**
     * 关联到模型的数据表
     *
     *  Schema: stuffs
     *      id,
     *      user_id,
     *      likeable_id,
     *      likeable_type,
     *      kind, // 类型：1.图片；2.视频；3.--
     * @var string
     */
    protected $table = 'likes';
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'likeable_id', 'likeable_type'];
    
    /**
     * 获取所属的likeable模型
     */
    public function likeable()
    {
        return $this->morphTo();
    }
    
    /**
     * 获取用户
     *
     * Defines an inverse one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function user()
    {
        return $this->belongsTo('App\Http\Models\User');
    }
    
}
