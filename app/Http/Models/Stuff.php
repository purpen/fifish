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
     *      content,
     *      address,
     *      city,
     *      kind,   // 类型：1.图片；2.视频；3.--
     *      sticked,sticked_at
     *      featured,featured_at
     *      view_count,like_count,comment_count,share_count
     *
     * @var string
     */
    protected $table = 'stuffs';
    
    /**
     * 添加不存在的属性
     */
    protected $appends = ['cover'];
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'content', 'kind', 'address', 'city'];
    
    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = ['sticked', 'featured'];
    
    /**
     * 在数组中显示的属性
     *
     * @var array
     */
    protected $visible = ['id', 'user', 'cover', 'content', 'tags', 'sticked', 'sticked_at', 'featured', 'featured_at', 'view_count', 'like_count', 'comment_count', 'kind', 'created_at', 'address', 'city'];
    
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
     * 获取分享的所有的点赞
     */
    public function likes()
    {
        return $this->morphMany('App\Http\Models\Like', 'likeable');
    }
    
    /**
     * 获取原文件及封面图
     */
    public function getCoverAttribute ()
    {
        if ($this->assets()->count()) {
            return $this->assets()->orderBy('created_at', 'desc')->first();
        }
        return [];
    }
    
    /**
     * 获取所有分享的照片
     */
    public function assets()
    {
        return $this->morphMany('App\Http\Models\Asset', 'assetable');
    }
    
    /**
     * 获取分享的所有标签
     */
    public function tags()
    {
        return $this->morphToMany('App\Http\Models\Tag', 'taggable');
    }
    
    /**
     * 获取照片/视频截图
     */
    public function getAssetAttribute($value)
    {
        return Asset::find($value);
    }
    
    /**
     * 范围：获取精选列表
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }
    
    /**
     * 范围：获取推荐列表
     */
    public function scopeSticked($query)
    {
        return $query->where('sticked', 1);
    }
    
}
