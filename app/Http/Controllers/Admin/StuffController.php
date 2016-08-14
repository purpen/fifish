<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Stuff;
use App\Http\Transformers\StuffTransformer;

class StuffController extends Controller
{
    public function __construct()
    {
        // 设置菜单状态
        
    }
    
    /**
     * stuff 列表
     */
    public function index() 
    {
        $stuffs = Stuff::with('user','assets')->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.stuff.index', ['stuffs' => $stuffs]);
    }
    
    /**
     * 删除
     */
    public function destroy(Request $request, $id)
    {
        $res = Stuff::findOrFail($id)->delete();
        
        return redirect('/admin/stuff');
    }
    
}
