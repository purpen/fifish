<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function permissions()
    {
        return $this->belongsToMany('App\Http\Models\Permission');
    }
    
    /**
     * 给角色添加权限
     */
    public function givePermissionTo($permission)
    {
        return $this->permissions()->save($permission);
    }
    
}
