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
     * 测试添加搜索
     */
    public function search()
    {
        //phpinfo();
        $data = array(
            'oid' => 3,
            'pid' => 'stuff_3',
            'kind' => 'Stuff',
            'user_id' => 1,
            'tid' => 1,
            'tags' => '无效,无限,参与,test,city,baby,beijing',
            'title' => '这是测试内容3',
            'created_on' => time(),
            'updated_on' => time(),
        );
        return XSUtil::add($data);
    }


    /**
     * 删除索引
     */
    public function delSearch(Request $request)
    {
        $id = $request->input('id', null);
        $ok = XSUtil::delIds($id);
        if($ok['success']){
            echo $ok['msg'];
        }else{
            echo $ok['msg'];
        }
    }
    
    
}
