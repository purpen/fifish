<?php
/**
 * 测试控制器
 * @author tianshuai
 */
namespace App\Http\Controllers;

use Config;
use App\Http\Requests;
use Illuminate\Http\Request;

use App\Http\ApiHelper;
use App\Http\Utils\ImageUtil;

use App\Http\Models\User;
use App\Jobs\SendReminderEmail;

use App\Http\Utils\XSUtil;

class TestController extends Controller
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

    }
    

    /**
     * 特殊活动展示
     */
    public function search()
    {
        phpinfo();
        $data = array(
            'oid' => 1,
            'pid' => 'stuff_1',
            'kind' => 'Stuff',
            'user_id' => 1,
            'tid' => 1,
            'tags' => '测试, test, 你好, hello',
            'title' => '这是测试内容',
            'created_on' => time(),
            'updated_on' => time(),
        );
        return XSUtil::add($data);
    }
    
}
