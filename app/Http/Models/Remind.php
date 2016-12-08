<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Remind extends Model
{
    /**
     * 关联到模型的数据表
     *
     *  Schema: reminds
     *   user_id
     *   sender_id
     *   evt,content
     *   remindable_id,remindable_type
     *   related_id,
     *   readed,from_site
     *   created_at,updated_at
     *
     * @var string
     */
    protected $table = 'reminds';
    
    /**
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'sender_id', 'evt', 'content', 'remindable_id', 'remindable_type', 'related_id', 'from_site'];
    
    /**
     * 不能被批量赋值的属性
     *
     * @var array
     */
    protected $guarded = ['readed'];
    
    /**
     * 在数组中显示的属性
     *
     * @var array
     */
    protected $visible = ['id', 'user_id', 'sender_id', 'evt', 'content', 'remindable_id', 'remindable_type', 'related_id', 'from_site'];
    
    /**
     * 获取所有拥有的 remindable 模型。
     */
    public function remindable()
    {
        return $this->morphTo();
    }
    
    /**
     * 获取用户
     */
    public function sender()
    {
        return $this->belongsTo('App\Http\Models\User', 'sender_id');
    }
    
    /**
     * 获取所属的对象
     */
    public function stuff()
    {
        return $this->belongsTo('App\Http\Models\Stuff', 'related_id');
    }
    
    /**
     * 获取动作的标签
     */
    public function getEvtLabelAttribute()
    {
        switch ($this->evt) {
            case 1:
                $label = '发布了';
                break;
            case 2:
                $label = '评论了';
                break;
            case 3:
                $label = '赞了';
                break;
        }
        
        return $label;
    }
    
}
