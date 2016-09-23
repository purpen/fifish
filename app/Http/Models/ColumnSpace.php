<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ColumnSpace extends Model
{    
    /**
     * 关联到模型的数据表
     *
     *  Schema: column_spaces
     *      id,
     *      user_id,
     *      name,
     *      summary,
     *      type,   // 类型：1.官网；2.APP；
     *      status, // 状态：0.隐藏；1.显示；
     *      count,
     *      width,height,
     *
     * @var string
     */
    protected $table = 'column_spaces';

    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'name', 'summary', 'type', 'width', 'height'];
    
    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = ['status', 'count'];
    
    /**
     * 在数组中显示的属性
     *
     * @var array
     */
    protected $visible = ['id', 'status', 'count', 'user_id', 'name', 'summary', 'type', 'width', 'height'];

    /**
     * 类型转换
     */
    protected $casts = [  
        'type' => 'integer',
        'status' => 'integer',
        'count' => 'count',
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
     * 获取所有栏目
     *
     * Defines a one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function columns()
    {
        return $this->hasMany('App\Http\Models\Column', 'column_space_id');
    }

    
}
