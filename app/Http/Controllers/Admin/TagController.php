<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Tag;
use App\Http\Transformers\StuffTransformer;

class TagController extends Controller
{
    public function __construct()
    {
        // 设置菜单状态
        View()->share('sitebar_menu_tag', 'active');
    }
    
    /**
     * stuff 列表
     */
    public function index() 
    {
        $tags = Tag::orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.tag.index', ['tags' => $tags]);
    }
    
    /**
     * 删除
     */
    public function destroy(Request $request, $id)
    {
        $res = Tag::findOrFail($id)->delete();
        
        return redirect('/admin/tags');
    }
    
}
