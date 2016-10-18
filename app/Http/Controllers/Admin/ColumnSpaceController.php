<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\ColumnSpace;

class ColumnSpaceController extends Controller
{
    public function __construct()
    {
        // 设置菜单状态
        View()->share('sitebar_menu_spaces', 'active');
    }
    
    /**
     * 栏目列表
     */
    public function index() 
    {
        $spaces = ColumnSpace::orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.space.index', ['spaces' => $spaces]);
    }
    
    /**
     * 新增栏目
     */
    public function create()
    {            
        return view('admin.space.create');
    }
    
    /**
     * 栏目保存
     */
    public function store(Request $request)
    {
        $messages = [
            'name.unique' => '标识被占用!',
        ];
        $this->validate($request, [
           'name' => 'required|unique:column_spaces|max:25',
           'type' => 'required', 
        ], $messages);
        
        $somedata = $request->only([
            'name', 'type', 'summary'
        ]);
        $somedata['user_id'] = \Auth::user()->id;
        
        $column = ColumnSpace::create($somedata);
        
        return redirect('/admin/columnspaces');
    }
    
    /**
     * 栏目编辑
     */
    public function edit(Request $request, $id)
    {
        $space = ColumnSpace::findorfail($id);
        
        return view('admin.space.edit', ['space' => $space]);
    }
    
    /**
     * 栏目更新
     */
    public function update(Request $request, $id)
    {
        $space = ColumnSpace::findorfail($id);
        
        $space->type = $request->input('type');
        $space->summary = $request->input('summary');
        
        $ok = $space->save();
        
        return redirect('/admin/columnspaces');
    }
    
    /**
     * 栏目删除
     */
    public function destroy(Request $request, $id)
    {
        $res = ColumnSpace::findOrFail($id)->delete();
        
        return redirect('/admin/columnspaces');
    }
    
}
