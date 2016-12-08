<?php

namespace App\Observers;

class FollowObserver
{
    /**
     * 创建后，更新所属对象的计数
     */
    public function created ($follow)
    {
        $follow->user()->increment('follow_count');
        $follow->follower()->increment('fans_count');
    }
    
    /**
     * 删除后, 更新所属对象的计数
     */
    public function deleting ($follow)
    {
        if ($follow->user()->first()->follow_count > 0) {
            $follow->user()->decrement('follow_count');
        }
        
        if ($follow->follower()->first()->fans_count > 0) {
            $follow->follower()->decrement('fans_count');
        }
    }
    
}