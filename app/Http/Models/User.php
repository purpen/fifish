<?php

namespace App\Http\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{    
    /**
     * 关联到模型的数据表
     *
     *  Schema: users
     *      id,
     *      account,password
     *      username,email,phone,job,zone
     *      sex,summary,
     *      tags,标签
     *      role_id,
     *      follow_count,按照计数
     *      fans_count,粉丝数
     *      stuff_count,分享数
     *      like_count，点赞数
     *      from_site,来自那个网站
     *      status
     *      first_login,第一个
     *      last_login　最后一个
     *      remember_token
     *      created_at,updated_at
     *      alert_fans_count,返回的粉丝数
     *      alert_like_count,返回的点赞数
     *      alert_comment_count，返回的评论数
     *      wechat_openid,微信id
     *      wechat_access_token,微信令牌
     *      wechat_unionid
     *      facebook_openid,facebook_ID
     *      facebook_access_token,facebook令牌
     *      instagram_openid,instagram_ID
     *      instagram_access_token,instagram令牌
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
        'account', 'username', 'password', 'email', 'phone', 'sex' , 'summary', 'wechat_openid', 'wechat_access_token', 'wechat_unionid', 'facebook_openid', 'facebook_access_token','instagram_openid', 'instagram_access_token', 'from_site'
    ];
    
    /**
     * 添加不存在的属性
     */
    protected $appends = ['avatar', 'alert_total_count'];
    
    /**
     * 在数组中显示的属性
     *
     * @var array
     */
    protected $visible = ['id', 'username', 'summary', 'avatar', 'first_login', 'last_login'];
        
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
     * 获取提醒总数量
     */
    public function getAlertTotalCountAttribute()
    {
        return $this->alert_comment_count + $this->alert_like_count + $this->alert_fans_count;
    }
    
    /**
     * 获取用户头像
     */
    public function getAvatarAttribute()
    {
        // 设置默认头像
        $avatar = [
            'small' => config('app.static_url').'/img/avatar!smx50.png',
            'large' => config('app.static_url').'/img/avatar!lgx180.png',
        ];
                
        // 验证是否有头像 
        if ($this->assets()->count()){
            $asset = $this->assets()->orderBy('created_at', 'desc')->first();
            $avatar['small'] = $asset->file->small;
            $avatar['large'] = $asset->file->large;
        }
        
        return (object)$avatar;
    }
    
    /**
     * 修正个性标签显示（转换化为数组）
     */
    public function getTagsLabelAttribute()
    {
        return array_values(array_unique(preg_split('/[,，;；\s]+/u', $this->tags)));
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
    
    /**
     * 范围：获取第三方登录用户
     */
    public function scopeOfSocialite($query, $type, $uid)
    {
        switch ($type) {
            case 'wechat':
                return $query->where('wechat_openid', $uid);
            case 'facebook':
                return $query->where('facebook_openid', $uid);
            case 'instagram':
                return $query->where('instagram_openid', $uid);
            default:
                return $query->where('account', $uid);
        }
    }
    
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * 更新精选状态
     */
    static public function upStatus($id, $status=2)
    {
        $user = self::findOrFail($id);
        $user->status = $status;
        return $user->save();
    }
}
