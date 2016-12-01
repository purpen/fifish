<?php

namespace App\Observers;

use App\Jobs\XSBuildIndex;
use Illuminate\Foundation\Bus\DispatchesJobs;

class UserObserver 
{
    use DispatchesJobs;
    
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
        
        
        // 创建用户后，添加至全文索引
        $idx_job = (new XSBuildIndex($user->id, 'User', 'Add'))->onQueue('indexes');
        $this->dispatch($idx_job);
    }
    
    /**
     * 更新后，更新所属对象事件
     */
    public function updated ($user) {
        // 更新全文索引
        $idx_job = (new XSBuildIndex($user->id, 'User', 'Update'))->onQueue('indexes');
        $this->dispatch($idx_job);
    }
    
    /**
     * 更新后，更新所属对象事件
     */
    public function saved ($user) {
        // 更新全文索引
        $idx_job = (new XSBuildIndex($user->id, 'User', 'Update'))->onQueue('indexes');
        $this->dispatch($idx_job);
    }
    
    /**
     * 删除或禁用用户后 事件
     */
    public function deleted ($user)
    {
        // 创建用户后，添加至全文索引
        $idx_job = (new XSBuildIndex($user->id, 'User', 'Delete'))->onQueue('indexes');
        $this->dispatch($idx_job);
    }
    
}