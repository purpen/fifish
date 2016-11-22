<?php

namespace App\Http\Controllers\Admin;

use Config;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Asset;
use App\Http\Models\Column;
use App\Http\Models\ColumnSpace;
use App\Http\Utils\ImageUtil;

class ColumnController extends Controller
{
    public function __construct()
    {
        // 设置菜单状态
        View()->share('sitebar_menu_columns', 'active');
    }
    
    /**
     * 栏目列表
     */
    public function index() 
    {
        $columns = Column::orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.column.index', ['columns' => $columns]);
    }
    
    /**
     * 新增栏目
     */
    public function create()
    {
        $spaces = ColumnSpace::opened()->orderBy('created_at', 'desc')->get();
        
        $token = ImageUtil::qiniuToken(false, 'photo', 0, 'Column', \Auth::user()->id);
        $upload_url = Config::get('filesystems.disks.qiniu.upload_url');
            
        return view('admin.column.create', [
            'spaces' => $spaces,
            'token' => $token,
            'upload_url' => $upload_url
        ]);
    }
    
    /**
     * 栏目保存
     */
    public function store(Request $request)
    {
        $messages = [
            'column_space_id.required' => '所属位置不能为空!',
            'title.required' => '标题不能为空',
            'url.required' => '目标链接不能为空',
            'cover_id.required' => '请上传一张图片',
        ];
        $this->validate($request, [
           'column_space_id' => 'required',
           'title' => 'required', 
           'url' => 'required',
           'cover_id' => 'required',
           
        ], $messages);
        
        $somedata = $request->only([
            'column_space_id', 'title', 'sub_title', 'url', 'cover_id', 'summary'
        ]);
        $somedata['user_id'] = \Auth::user()->id;
        
        $column = new Column();
        $column->fill($somedata);
        $res = $column->save();
        
        // 更新图片（支持图片先上传后保存资料）
        $cover_id = $request->input('cover_id');
        if ($cover_id) {
            $asset = Asset::findOrFail((int)$cover_id);
            $asset->assetable_id = $column->id;
            $asset->save();
        }
        
        return redirect('/admin/columns');
    }
    
    /**
     * 附件编辑
     */
    public function edit(Request $request, $id)
    {
        
    }
    
    /**
     * 附件更新
     */
    public function update(Request $request, $id)
    {
        
    }
    
    /**
     * 附件删除
     */
    public function destroy(Request $request, $id)
    {
        $res = Column::findOrFail($id)->delete();
        
        return redirect('/admin/columns');
    }
}
