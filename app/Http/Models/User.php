<?php

namespace App\Http\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{    
    /**
     * 关联到模型的数据表
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
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
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
