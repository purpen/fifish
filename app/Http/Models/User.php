<?php

namespace App\Http\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{    
    /**
     * 关联到模型的数据表
     *
     *  Schema: users
     *      id,
     *      account,password
     *      username,email,phone,job,zone
     *      avatar_url,sex,summary,tags
     *      role_id,
     *      follow_count,fans_count,stuff_count,like_count
     *      from_site,status
     *      remember_token
     *      created_at,updated_at
     *
     * @var string
     */
    protected $table = 'users';
    
    /**
     * The attributes that are mass assignable.
     * 可以被批量赋值的属性.
     *
     * @var array
     */
    protected $fillable = [
        'account', 'username', 'password', 'email', 'phone', 'summary',
    ];
    
    /**
     * 在数组中显示的属性
     *
     * @var array
     */
    protected $visible = ['id', 'username', 'summary'];
        
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'role_id', 'from_site', 'status', 'created_at'
    ];
    
    /**
     * 获取用户头像。
     */
    public function assets()
    {
        return $this->morphMany('App\Http\Models\Asset', 'assetable');
    }
    
    /**
     * 获取用户分享列表
     *
     * Defines a one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function stuffs()
    {
        return $this->hasMany('Stuff');
    }
    
    /**
     * 获取发表的评论列表
     *
     * Defines a one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function comments()
    {
        return $this->hasMany('Comment');
    }
    
}
