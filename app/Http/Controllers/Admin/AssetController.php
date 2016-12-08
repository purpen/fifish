<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Asset;
use App\Http\Utils\ImageUtil;

class AssetController extends Controller
{
    public function __construct()
    {
        // 设置菜单状态
        View()->share('sitebar_menu_assets', 'active');
    }
    
    /**
     * 附件列表
     */
    public function index() 
    {
        $assets = Asset::orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.asset.index', ['assets' => $assets]);
    }
    
    /**
     * 附件保存
     */
    public function store()
    {
        
    }
    
    /**
     * 附件编辑
     */
    public function edit()
    {
        
    }
    
    /**
     * 附件更新
     */
    public function update()
    {
        
    }
    
    /**
     * ajax附件删除
     */
    public function ajaxDestroy(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);
        
        $store_path = $asset->filepath;
        // 删除记录
        $ok = $asset->delete();
        if ($ok) {
            // 从云存储里删除文件
            $res = ImageUtil::deleteQiniuFile($store_path);
        }
        
        return response()->json([
            'id' => $id,
            'status_code' => 200,
            'status_message' => '删除附件成功！',
        ]);
    }
    
    /**
     * 附件删除
     */
    public function destroy()
    {
        
        
        
    }
}
