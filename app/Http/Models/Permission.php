<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    
    public function roles()
    {
        return $this->belongsToMany('App\Http\Models\Role');
    }
}
