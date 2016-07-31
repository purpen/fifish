<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Stuff extends Model
{    
    /**
     * 关联到模型的数据表
     *
     *  Schema: stuffs
     *      id,
     *      user_id,
     *      asset_id,
     *      content,
     *      tags,
     *      sticked,sticked_at
     *      featured,featured_at
     *      view_count,like_count,comment_count,share_count
     *
     * @var string
     */
    protected $table = 'stuffs';
    
    /**
     * 获取分享用户
     *
     * Defines an inverse one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function user()
    {
        return $this->belongsTo('User');
    }
    
    /**
     * 获取所属评论
     *
     * Defines a one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function comments()
    {
        return $this->hasMany('Comment', 'target_id');
    }
    
}
