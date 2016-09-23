<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{                
    /**
     * 关联到模型的数据表
     *
     *  Schema: follow
     *      id,
     *      user_id,
     *      follow_id,
     *
     * @var string
     */
    protected $table = 'follow';
    
    /**
     * 表明模型是否应该被打上时间戳
     *
     * @var bool
     */
    public $timestamps = false;
    
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'follow_id'];
    
    
    /**
     * 范围约束：某人的所有粉丝
     */
    public function scopeOfFans($query, $uid)
    {
        return $query->where('follow_id', $uid);
    }
    
    /**
     * 范围约束：某人的所有关注者
     */
    public function scopeOfFollowers($query, $uid)
    {
        return $query->where('user_id', $uid);
    }
    
    /**
     * 获取用户信息
     *
     * Defines an inverse one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function user()
    {
        return $this->belongsTo('App\Http\Models\User');
    }
    
    /**
     * 获取用户信息
     *
     * Defines an inverse one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function follower()
    {
        return $this->belongsTo('App\Http\Models\User', 'follow_id');
    }

    
}
