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
     *      asset,
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
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'asset_id', 'content', 'tags'];
    
    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = ['sticked', 'featured'];
    
    /**
     * 获取分享用户
     *
     * Defines an inverse one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function user()
    {
        return $this->belongsTo('App\Http\Models\User');
    }
    
    /**
     * 获取所属评论
     *
     * Defines a one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function comments()
    {
        return $this->hasMany('App\Http\Models\Comment', 'target_id');
    }
    
    /**
     * 获取照片/视频截图
     */
    public function getAssetAttribute($value)
    {
        return Asset::find($value);
    }
    
}
