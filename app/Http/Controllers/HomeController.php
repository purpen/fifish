<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Http\Utils\ImageUtil;

use App\Http\Models\User;
use App\Jobs\SendReminderEmail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }
    
    
    /**
     * 设置测试任务
     */
    public function job()
    {        
        
        $user = User::findOrFail(1);
        
        // 为任务指定队列
        $job = (new SendReminderEmail($user))->onQueue('emails');
        
        $this->dispatch($job);
        
        return 'ok';
    }
    
    public function avatar()
    {
        $token = ImageUtil::qiniuToken();
        
        return view('avatar', ['token' => $token]);
    }
}
