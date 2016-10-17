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
        $body = array(
            "filename" => "16-10-17+15%3A20%3A49%3A55249429.MOV",
            "filepath" => "video\/161017\/d094eecb947ff5a8c567d0e5fa3649ba.MOV",
            "size" => 2842564,
            "width" => 0,
            "height" => 0,
            "mime" => "video\/quicktime",
            "duration" => 27.916667,
            "vbyte" => 2842564,
            "desc" => "",
            "assetable_id" => 0,
            "assetable_type" => "Stuff",
            "kind" => 2,
            "user_id" => 1,
        );        
        // save asset
        $asset = new Asset();
        $asset->fill($body);
        $res = $asset->save();
        
        //print_r($res);
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
