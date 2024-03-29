<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
     *      city,lat,lng
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
    protected $fillable = ['user_id', 'content', 'kind', 'address', 'city', 'lat', 'lng', 'view_count'];
    
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
        return null;
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
     * 修改时间格式
     *   **距离现在时间**      **显示格式**
     *    < 1小时                xx分钟前
     *    1小时-24小时            xx小时前 
     *    1天-10天               xx天前
     *    >7天                  直接显示日期
     */
    public function getCreatedAtAttribute($date)
    {
        if (Carbon::now() > Carbon::parse($date)->addDays(7)) {
            return Carbon::parse($date)->format('Y-m-d H:i');
        }
        
        return Carbon::parse($date)->diffForHumans();
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

    /**
     * 更新推荐状态
     */
    static public function upStick($id, $sticked=1)
    {
        $stuff = self::findOrFail($id);
        $stuff->sticked = $sticked;
        $stuff->sticked_at = date('Y-m-d H:i:s');
        return $stuff->save();
    }

    /**
     * 更新精选状态
     */
    static public function upFeatur($id, $featured=1)
    {
        $stuff = self::findOrFail($id);
        $stuff->featured = $featured;
        $stuff->featured_at = date('Y-m-d H:i:s');
        return $stuff->save();
    }
}
