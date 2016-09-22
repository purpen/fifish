<?php

namespace App\Http\Controllers\Admin;

use Config;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Stuff;
use App\Http\Transformers\StuffTransformer;
use App\Http\Utils\ImageUtil;

class StuffController extends Controller
{
    public function __construct()
    {
        // 设置菜单状态
        View()->share('sitebar_menu_stuff', 'active');
    }
    
    /**
     * stuff 列表
     */
    public function index() 
    {
        $stuffs = Stuff::with('user','assets')->orderBy('created_at', 'desc')->paginate(2);
        
        return view('admin.stuff.index', ['stuffs' => $stuffs]);
    }
    
    /**
     * 新增分享
     */
    public function create()
    {
        $token = ImageUtil::qiniuToken();
        $domain = 'photo';
        $upload_url = Config::get('filesystems.disks.qiniu.upload_url');
        
        return view('admin.stuff.create', [
            'token' => $token, 
            'domain' => $domain,
            'upload_url' => $upload_url
        ]);
    }
    
    
    /**
     * 删除
     */
    public function destroy(Request $request, $id)
    {
        $res = Stuff::findOrFail($id)->delete();
        
        return redirect('/admin/stuffs');
    }
    
}
