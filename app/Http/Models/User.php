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
    
    // 管理员
    const ROLE_ADMINISTER = 9;
    
    // 普通用户
    const ROLE_PEOPLE = 1;
    
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
     * 与角色关系
     *
     * Defines a belong-to-many relationship.
     */
    public function roles()
    {
        return $this->belongsToMany('App\Http\Models\Role');
    }
    
    /**
     * 判断用户是否具有某个角色
     */
    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }
        
        return !! $role->intersect($this->roles)->count();
    }
    
    /**
     * 判断用户是否具有某权限
     */
    public function hasPermission($permission)
    {
        return $this->hasRole($permission->roles);
    }
    
    /**
     * 给用户分配角色
     */
    public function assignRole($role)
    {
        return $this->roles()->save(
            Role::whereName($role)->firstOrFail()
        );
    }
    
    /**
     * 获取用户头像。
     */
    public function assets()
    {
        return $this->morphMany('App\Http\Models\Asset', 'assetable');
    }
    
    /**
     * 获取关注者
     *
     * Defines a one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function followers()
    {
        return $this->hasMany('App\Http\Models\Follow');
    }
    
    /**
     * 获取粉丝列表
     *
     * Defines a one-to-many relationship.
     * @see http://laravel.com/docs/eloquent#one-to-many
     */
    public function fans()
    {
        return $this->hasMany('App\Http\Models\Follow', 'follow_id');
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
    
    
    /**
     * 范围：获取管理员
     */
    public function scopeAdminister($query)
    {
        return $query->where('role_id', self::ROLE_ADMINISTER);
    }
    
    /**
     * 范围：获取普通用户
     */
    public function scopePeople($query)
    {
        return $query->where('role_id', self::ROLE_PEOPLE);
    }
    
}
