<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{    
    /**
     * 关联到模型的数据表
     *
     *  Schema: columns
     *      id,
     *      user_id,
     *      title,
     *      sub_title,
     *      summary,
     *      content,
     *      url,
     *      type,   //  位置：1.官网；2.APP；
     *      evt,    // 转向(用于app)：1.url；2.stuff详情；3.个人主页；4.－－；
     *      cover_id,
     *      status,
     *      view_count,
     *      order,
     *
     * @var string
     */
    protected $table = 'columns';
    
    /**
     * 添加不存在的属性
     */
    protected $appends = ['cover'];
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'cover_id', 'content', 'type', 'title', 'sub_title', 'summary', 'url', 'evt', 'status', 'order'];
    
    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = ['view_count'];
    
    /**
     * 在数组中显示的属性
     *
     * @var array
     */
    protected $visible = ['id', 'user_id', 'user', 'cover_id', 'content', 'type', 'title', 'sub_title', 'summary', 'url', 'evt', 'status', 'order', 'view_count'];


    /**
     * 类型转换
     */
    protected $casts = [  
        'view_count' => 'integer'
    ];
    
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
     * 获取封面图
     */
    public function getCoverAttribute ()
    {
        if ($this->assets()->count()) {
            return $this->assets()->first();
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
