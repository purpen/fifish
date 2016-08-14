<?php

namespace App\Observers;

class CommentObserver
{
    /**
     * 创建后，更新所属对象的计数
     */
    public function created ($comment)
    {
        return $comment->stuff()->increment('comment_count');
    }
    
    /**
     * 删除后, 更新所属对象的计数
     */
    public function deleted ($comment)
    {
        return $comment->stuff()->decrement('comment_count');
    }
    
}