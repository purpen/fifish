<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Asset;
use App\Http\Models\Tag;
use App\Http\Transformers\StuffTransformer;
use App\Http\Utils\ImageUtil;

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
        $token = ImageUtil::qiniuToken(false, 'photo', 0, 'Tag', \Auth::user()->id);
        $upload_url = Config::get('filesystems.disks.qiniu.upload_url');
            
        return view('admin.tag.create', [
            'token' => $token,
            'upload_url' => $upload_url
        ]);
    }
    
    /**
     * 保存标签
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'min:2', 'max:15'],
            'display_name' => ['required', 'min:2', 'max:15']
        ]);
        
        $somedata = $request->only([
            'name', 'display_name', 'description'
        ]);
        
        $tag = new Tag();
        $tag->fill($somedata);
        $res = $tag->save();
        
        // 更新图片（支持图片先上传后保存资料）
        $asset_id = $request->input('asset_id');
        if ($asset_id) {
            $asset = Asset::findOrFail((int)$asset_id);
            $asset->assetable_id = $tag->id;
            $asset->save();
        }
        
        return redirect('/admin/tags');
    }
    
    /**
     * 标签编辑
     */
    public function edit(Request $request, $id)
    {
        $tag = Tag::findorfail($id);
        
        $token = ImageUtil::qiniuToken(false, 'photo', 0, 'Tag', \Auth::user()->id);
        $upload_url = Config::get('filesystems.disks.qiniu.upload_url');
        
        return view('admin.tag.edit', [
            'tag' => $tag,
            'token' => $token,
            'upload_url' => $upload_url
        ]);
    }
    
    public function stick(Request $request, $id)
    {
        $ok = Tag::upStick($id, 1);
        return redirect('/admin/tags');
    }
    
    public function unstick(Request $request, $id)
    {
        $ok = Tag::upStick($id, 0);
        return redirect('/admin/tags');
    }
    
    
    /**
     * 标签更新
     */
    public function update(Request $request, $id)
    {
        $somedata = $request->only([
            'name', 'display_name', 'description'
        ]);
        
        $tag = Tag::findOrFail($id);
        $res = $tag->update($somedata);
        
        // 更新图片（支持图片先上传后保存资料）
        $asset_id = $request->input('asset_id');
        if ($asset_id) {
            $asset = Asset::findOrFail((int)$asset_id);
            $asset->assetable_id = $id;
            $asset->save();
        }
        
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
