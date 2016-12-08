<?php

namespace App\Observers;

use App\Http\Models\User;

class LikeObserver
{
    /**
     * 创建后，更新所属对象的计数
     */
    public function created ($like)
    {        
        $stuff = $like->likeable()->first();
        $user_id = $like->user_id;
        
        // 添加提醒
        $res = $like->reminds()->create([
           'sender_id' => $user_id, 
           'user_id' => $stuff->user_id,
           'related_id' => $stuff->id,
           'evt' => config('const.events.like'),
        ]); 
        
        if ($res) {
            // 更新提醒的数量
            User::findOrFail($stuff->user_id)->increment('alert_like_count');
        }
        
        return $like->likeable()->increment('like_count');
    }
    
    /**
     * 删除后, 更新所属对象的计数
     */
    public function deleting ($like)
    {
        if ($like->likeable()->first()->like_count > 0) {
            return $like->likeable()->decrement('like_count');
        }
    }
    
}