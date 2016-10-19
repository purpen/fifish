<?php
/**
 * 网站的入口文件控制器
 * @author purpen
 */
namespace App\Http\Controllers;

use Config;
use App\Http\Requests;
use Illuminate\Http\Request;

use App\Http\ApiHelper;
use App\Http\Utils\ImageUtil;

use App\Http\Models\User;
use App\Jobs\SendReminderEmail;

use Redis;
use App\Http\Models\Asset;

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
     * 特殊活动展示
     */
    public function promo()
    {
        
    }
    
    /**
     * 设置测试任务
     */
    public function job()
    {           
        $user = User::findOrFail(1);
        
        // 为任务指定队列
        $job = (new SendReminderEmail($user))->onQueue('emails');
        
        $this->dispatch(new SendReminderEmail($user));
        
        return 'ok';
    }
    
    public function avatar()
    {        
        $token = ImageUtil::qiniuToken(false, 'avatar', 1, 'User', 1);
        $upload_url = Config::get('filesystems.disks.qiniu.upload_url');
        
        return view('avatar', [
            'token' => $token,
            'upload_url' => $upload_url
        ]);
    }
}
