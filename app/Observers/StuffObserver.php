<?php

namespace App\Observers;

use App\Http\Models\Stuff;

class StuffObserver
{
    /**
     * 创建后，更新所属对象的计数
     */
    public function created ($stuff)
    {   
        return $stuff->user()->increment('stuff_count');
    }
    
    /**
     * 删除后, 更新所属对象的计数
     */
    public function deleted ($stuff)
    {
        // 限制递减数量
        if ($stuff->stuff_count > 0) {
            return $stuff->user()->decrement('stuff_count');
        }
    }
    
}