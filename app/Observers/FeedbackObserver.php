<?php

namespace App\Observers;

class FeedbackObserver
{
    /**
     * 创建反馈意见后，发通知给管理员
     */
    public function created ($feedback)
    {
        //echo 'You have a feedback!!!'.date('Y-m-d H:i:s');
    }
    
}