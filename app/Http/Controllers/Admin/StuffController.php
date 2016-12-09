<?php

namespace App\Http\Controllers\Admin;

use Config;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Stuff;
use App\Http\Models\Asset;
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
        $stuffs = Stuff::with('user','assets')->orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.stuff.index', ['stuffs' => $stuffs]);
    }
    
    /**
     * 新增分享
     */
    public function create()
    {
        $videoToken = ImageUtil::qiniuToken(false, 'video', 0, 'Stuff', \Auth::user()->id);
        $token = ImageUtil::qiniuToken(false, 'photo', 0, 'Stuff', \Auth::user()->id);
        $upload_url = Config::get('filesystems.disks.qiniu.upload_url');
        
        return view('admin.stuff.create', [
            'videoToken' => $videoToken,
            'token' => $token,
            'upload_url' => $upload_url
        ]);
    }

    /*
     * 保存
     */
    public function store(Request $request)
    {

        $somedata = $request->only([
            'content'
        ]);
        $somedata['user_id'] = \Auth::user()->id;

        $stuff = new Stuff();
        $stuff->fill($somedata);
        $res = $stuff->save();

        // 更新图片（支持图片先上传后保存资料）
        $asset_id = $request->input('asset_id');
        if ($asset_id) {
            $asset = Asset::findOrFail((int)$asset_id);
            $asset->assetable_id = $stuff->id;
            $asset->save();
        }

        //更新视频
        $video_id = $request->input('video_id');
        if($video_id) {
            $video = Asset::findOrFail((int)$video_id );
            $video->assetable_id = $stuff->id;
            $video->save();
        }

        return redirect('/admin/stuffs');
    }

    /**
     * 编辑
     */
    public function edit(Request $request, $id)
    {
        $stuff = Stuff::findorfail($id);
        $videoToken = ImageUtil::qiniuToken(false, 'video', 0, 'Stuff', \Auth::user()->id);
        $token = ImageUtil::qiniuToken(false, 'photo', 0, 'Stuff', \Auth::user()->id);
        $upload_url = Config::get('filesystems.disks.qiniu.upload_url');

        return view('admin.stuff.edit', [
            'stuff' => $stuff,
            'token' => $token,
            'videoToken' => $videoToken,
            'upload_url' => $upload_url
        ]);
    }

    /**
     * 标签更新
     */
    public function update(Request $request, $id)
    {
        $somedata = $request->only([
            'content'
        ]);
        $stuff = Stuff::findOrFail($id);
        $res = $stuff->update($somedata);

        // 更新图片（支持图片先上传后保存资料）
        $asset_id = $request->input('asset_id');
        if ($asset_id) {
            $asset = Asset::findOrFail((int)$asset_id);
            $asset->assetable_id = $id;
            $asset->save();
        }

        //更新视频
        $video_id = $request->input('video_id');
        if($video_id) {
            $video = Asset::findOrFail((int)$video_id );
            $video->assetable_id = $stuff->id;
            $video->save();
        }

        return redirect('/admin/stuffs');
    }

    /*
     * 推荐
     */
    public function stick(Request $request, $id)
    {
        $ok = Stuff::upStick($id, 1);
        return redirect('/admin/stuffs');
    }

    public function unstick(Request $request, $id)
    {
        $ok = Stuff::upStick($id, 0);
        return redirect('/admin/stuffs');
    }

    /*
     * 精选
     */
    public function featur(Request $request, $id)
    {
        $ok = Stuff::upFeatur($id, 1);
        return redirect('/admin/stuffs');
    }

    public function unfeatur(Request $request, $id)
    {
        $ok = Stuff::upFeatur($id, 0);
        return redirect('/admin/stuffs');
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
