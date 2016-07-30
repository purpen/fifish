<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    /**
     * 关联到模型的数据表
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
    
    
    const STATE_FINFISHED = 4;
    
}
