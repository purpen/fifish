<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model 
{
    /**
     * Laravel 的关联查询中，经常使用 with 方法来避免 N+1 查询，但是 with 会将目标关联的所有字段全部查询出来
     * withOnly 方法则可以指定返回字段，用法与with相同
     *
     * @example Topic::limit(2)->withOnly('user', ['username'])->get();
     */
    public function scopeWithOnly($query, $relation, Array $columns)
    {
        return $query->with([$relation => function ($query) use ($columns) {
            $query->select(array_merge(['id'], $columns));
        }]);
    }
    
}
