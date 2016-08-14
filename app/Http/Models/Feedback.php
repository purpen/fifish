<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    /**
     * 默认值
     */
    const STATE_DEFAULT = 1;
    /**
     * 处理中
     */
    const STATE_PROCESSING = 2;
    /**
     * 无法处理/失败
     */
    const STATE_FAILED = 3;
    /**
     * 完成状态
     */
    const STATE_FINFISHED = 4;
    
    /**
     * 关联到模型的数据表
     *
     *  Schema: feedback
     *      id,
     *      contact,
     *      content,
     *      state, 状态：1.默认值；2.处理中；3.无法处理；4.处理完成
     *      created_at,updated_at
     *
     * @var string
     */
    protected $table = 'feedback';
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['contact', 'content'];
    
    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = ['state'];
    
    /**
     * 范围约束：获取不同状态下列表结果集
     */
    public function scopeOfState($query, $state)
    {
        return $query->where('state', $state);
    }
    
}
