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
        $file_content = file_get_contents('http://wx.qlogo.cn/mmopen/PiajxSqBRaEKYAILvZPR8r5PbxTHtk4YQnX8U6fgiaib4RApGvkM5UVyuFDaeRVsgdKnzpEZrG7xabrDTmoQ3RmjA/0', FILE_USE_INCLUDE_PATH);
        $upRet = ImageUtil::storeContentQiniu($file_content, 'avatar', 1, 'User', 1);
        dd($upRet);
    }
    

    /**
     * 测试添加搜索
     */
    public function search()
    {
        //phpinfo();
        $data = array(
            'oid' => 3,     // 原文ID (用户或作品ID)
            'pid' => 'stuff_3', // 索引自身ID eg: stuff_{id}, user_{id}
            'kind' => 'Stuff',  // 类型：Stuff, User
            'user_id' => 1,     // 创建者ID
            'tid' => 1,     // 原文类型ID 例如是作品 1.图片；2.视频
            'cid' => '',    // 原文分类ID
            'tags' => '无效,无限,参与,test,city,baby,beijing',  // 标签，多个用","分隔
            'title' => '这是测试标题',
            'content' => '这是内容',
            'created_on' => time(), // 时间截
            'updated_on' => time(),
        );

        // 无论创建或更新都用update 而不用add(防止数据重复)
        return XSUtil::update($data);
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
