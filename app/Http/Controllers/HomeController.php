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

use App;
use Redis;
use App\Http\Models\Asset;
use App\Http\Models\Column;
use App\Http\Models\ColumnSpace;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        View()->share('lang', true);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        // 获取媒体报道
        $space = ColumnSpace::where('name', 'page_media_news')->first();
        if ($space) {
            
        }
        $columns = $space->columns()->orderBy('created_at', 'desc')->paginate(3);
        
        return view('home', [
            'columns' => $columns
        ]);
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
        
        $this->dispatch($job);
        
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
