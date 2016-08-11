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
     *      total_count,
     *      asset_id,
     *      stick,sticked_at
     *
     * @var string
     */
    protected $table = 'tags';
    
    /**
     * Whether or not to enable timestamps.
     *
     * @var bool
     */
    public $timestamps = false;
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['name', 'index', 'asset_id'];
    
    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = ['total_count', 'stick', 'sticked_at'];
    
    
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
    
}
