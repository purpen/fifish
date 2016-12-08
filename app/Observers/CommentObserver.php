<?php

namespace App\Observers;

use App\Http\Models\User;

class CommentObserver
{
    /**
     * 创建后，更新所属对象的计数
     */
    public function created ($comment)
    {        
        $stuff = $comment->stuff()->first();
        $user_id = $comment->user_id;
        
        // 添加提醒
        $res = $comment->reminds()->create([
           'sender_id' => $user_id, 
           'user_id' => $stuff->user_id,
           'related_id' => $stuff->id,
           'evt' => config('const.events.comment'),
        ]); 
        
        if ($res) {
            // 更新提醒的数量
            User::findOrFail($stuff->user_id)->increment('alert_comment_count');
        }
        
        return $comment->stuff()->increment('comment_count');
    }
    
    /**
     * 删除后, 更新所属对象的计数
     */
    public function deleted ($comment)
    {
        if ($comment->stuff()->comment_count > 0) {
            return $comment->stuff()->decrement('comment_count');
        }
    }
    
}