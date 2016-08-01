<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * 关联到模型的数据表
     *
     *  Schema: comments
     *      id,
     *      user_id,
     *      target_id,
     *      content,
     *      reply_user_id,
     *      like_count,type
     *
     * @var string
     */
    protected $table = 'comments';
    
    /**
     * 要触发的所有关联关系
     * ”触发“创建其所属模型的updated_at时间戳
     * @var array
     */
    protected $touches = ['stuff'];
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'target_id', 'content', 'type'];
    
    /**
     * 获取所属的分享
     *
     * Defines an inverse one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function stuff()
    {
        return $this->belongsTo('Stuff', 'target_id');
    }
    
    /**
     * 获取评论用户
     *
     * Defines an inverse one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function user()
    {
        return $this->belongsTo('User');
    }
    
}
