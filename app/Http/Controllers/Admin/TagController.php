<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Tag;
use App\Http\Transformers\StuffTransformer;
use Validator;

class TagController extends Controller
{
    public function __construct()
    {
        // 设置菜单状态
        View()->share('sitebar_menu_tag', 'active');
    }
    
    /**
     * tags 列表
     */
    public function index() 
    {
        $tags = Tag::orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.tag.index', ['tags' => $tags]);
    }
    
    /**
     * 新增标签
     */
    public function create()
    {
        return view('admin.tag.create');
    }
    
    /**
     * 保存标签
     */
    public function store(Request $request)
    {
        $check = Validator::make($request->all(), [
            'name' => ['required', 'min:2', 'max:15'],
            'display_name' => ['required', 'min:2', 'max:15']
        ]);
        if ($check->fails()) {
            return Redirect::to('/admin/tag/create')
            			->withErrors($check);
        }
        
        $tag = Tag::create($request->only(['name', 'display_name', 'description']));
        
        return redirect('/admin/tags');
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
