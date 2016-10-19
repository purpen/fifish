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
     *      sticked,sticked_at
     *
     * @var string
     */
    protected $table = 'tags';
    
    /**
     * 添加不存在的属性
     */
    protected $appends = ['cover'];
    
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
    protected $guarded = ['total_count', 'sticked', 'sticked_at'];
    
    /**
     * 在数组中显示的属性
     *
     * @var array
     */
    protected $visible = ['id', 'name', 'display_name', 'cover', 'total_count'];
    
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
    
    /**
     * 获取Tag ID
     */
    static public function findTagsID($tags)
    {
        if (!is_array($tags)) {
            $tags = array_values(array_unique(preg_split('/[,，;；\s]+/u', $tags))); 
        }
        
        $tids = [];
        // 验证标签，获取标签ID
        for($i=0; $i<count($tags); $i++) {
            $tag = self::firstOrCreate(array('name' => $tags[$i]));
            $tids[] = $tag->id;
        }
        
        return $tids;
    }
    
}
