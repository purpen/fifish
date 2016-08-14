<?php

namespace App\Observers;


class UserObserver 
{
    /**
     * 新增用户前 事件
     */
    public function creating ($user)
    {
        return true;
    }
    
    /**
     * 新增用户后 事件
     */
    public function created ($user)
    {
        // 用户注册成功后，发送邮件通知
        // Mail::send('emails.welcome', ['user' => $user], function ($message) use ($user) {
        //     $message->to($user->email, $user->first_name . ' ' . $user->last_name)->subject('Welcome to My Awesome App, '.$user->first_name.'!');
        // });
        
    }
    
}