<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{    
    /**
     * 关联到模型的数据表
     *
     *  Schema: tags
     *      id,
     *      name,index
     *      display_name,description
     *      total_count,
     *      asset_id,
     *      stick,sticked_at
     *
     * @var string
     */
    protected $table = 'tags';
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['name', 'display_name', 'description', 'index', 'asset_id'];
    
    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = ['total_count', 'stick', 'sticked_at'];
    
    /**
     * 在数组中显示的属性
     *
     * @var array
     */
    protected $visible = ['id', 'name', 'display_name', 'total_count'];
    
    /**
     * 范围：获取推荐列表
     */
    public function scopeSticked($query)
    {
        return $query->where('sticked', 1);
    }
    
    /**
     * 获取相关的分享
     *
     * Defines a many-to-many relationship.
     * @see http://laravel.com/docs/eloquent#many-to-many
     */
    public function stuffs()
    {
        return $this->morphedByMany('App\Http\Models\Stuff', 'taggable');
    }
    
    /**
     * 获取标签封面图
     */
    public function assets()
    {
        return $this->morphMany('App\Http\Models\Asset', 'assetable');
    }
    
    /**
     * 更新推荐状态
     */
    static public function upStick($id, $sticked=1)
    {
        $tag = self::findOrFail($id);
        $tag->sticked = $sticked;
        $tag->sticked_at = date('Y-m-d H:i:s');
        return $tag->save();
    }
    
}
