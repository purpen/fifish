<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Log;

class Column extends Model
{    
    /**
     * 关联到模型的数据表
     *
     *  Schema: columns
     *      id,
     *      user_id,
     *      column_space_id,
     *      title,
     *      sub_title,
     *      summary,
     *      content,
     *      url,
     *      type,   // 位置：1.官网；2.APP；
     *      evt,    // 转向(用于app)：1.url；2.stuff详情；3.个人主页；4.－－；
     *      cover_id,
     *      status,
     *      view_count,
     *      order,  // 排序
     *
     * @var string
     */
    protected $table = 'columns';
    
    /**
     * 添加不存在的属性
     */
    protected $appends = ['cover', 'status_label'];
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'cover_id', 'column_space_id', 'content', 'type', 'title', 'sub_title', 'summary', 'url', 'evt', 'order'];
    
    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = ['view_count', 'status'];
    
    /**
     * 在数组中显示的属性
     *
     * @var array
     */
    protected $visible = ['id', 'user_id', 'column_space_id', 'cover', 'content', 'type', 'title', 'sub_title', 'summary', 'url', 'evt', 'status', 'order', 'view_count'];
    
    /**
     * 类型转换
     */
    protected $casts = [  
        'view_count'  =>  'integer'
    ];
    
    /**
     * 获取创建用户
     *
     * Defines an inverse one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function user()
    {
        return $this->belongsTo('App\Http\Models\User');
    }

    /**
     * 获取所属位置
     *
     * Defines an inverse one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function column_space()
    {
        return $this->belongsTo('\App\Http\Models\ColumnSpace');
    }
    
    /**
     * 获取封面图
     */
    public function getCoverAttribute ()
    {
        if ($this->assets()->first()) {
            return $this->assets()->orderBy('created_at', 'desc')->first();
        }
        return null;
    }
    
    /**
     * 获取所有的照片
     */
    public function assets()
    {
        return $this->morphMany('App\Http\Models\Asset', 'assetable');
    }

    /**
     * 更新精选状态
     */
    static public function upStatus($id, $status=1)
    {
        $column = self::findOrFail($id);
        $column->status = $status;
        return $column->save();
    }
    
}
