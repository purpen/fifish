<?php

namespace App\Http\Controllers\Admin;

use Validator;
use Illuminate\Http\Request;
use Config;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Models\Asset;
use App\Http\Models\User;
use App\Http\Utils\ImageUtil;
use App\Http\Transformers\UserTransformer;

class UserController extends Controller
{
    public function __construct()
    {
        // 设置菜单状态
        View()->share('sitebar_menu_users', 'active');
    }
    
    /**
     * 用户列表
     */
    public function index(Request $request) 
    {
        $type = $request->input('type', 'people');
        
        // 普通用户
        if ($type == 'people') {
            View()->share('sitebar_subnav_people', 'active');
            $users = User::people()->orderBy('created_at', 'desc')->paginate(10);
        } 
        // 管理员
        if ($type == 'administer') {
            View()->share('sitebar_subnav_administer', 'active');
            $users = User::administer()->orderBy('created_at', 'desc')->paginate(10);
        }
        
        return view('admin.user.index', ['users' => $users]);
    }

    /**
     * 新增标签
     */
    public function create()
    {
        $token = ImageUtil::qiniuToken(false, 'photo', 0, 'User', \Auth::user()->id);
        $upload_url = Config::get('filesystems.disks.qiniu.upload_url');

        return view('admin.user.create', [
            'token' => $token,
            'upload_url' => $upload_url
        ]);
    }

    /*
     *保存
     */
    public function store(UserRequest $request)
    {
        $somedata = $request->only([
            'account', 'username', 'email', 'phone' , 'summary' , 'sex'
        ]);
        // 设置默认密码
        $somedata['password'] = bcrypt('123456');
        $user = new User();
        $user->fill($somedata);
        $res = $user->save();

        // 更新图片（支持图片先上传后保存资料）
        $asset_id = $request->input('asset_id');
        if ($asset_id) {
            $asset = Asset::findOrFail((int)$asset_id);
            $asset->assetable_id = $user->id;
            $asset->save();
        }

        return redirect('/admin/users');
    }


    /*
     * 编辑
     */
    public function edit(Request $request, $id)
    {
        $user = User::findorfail($id);

        $token = ImageUtil::qiniuToken(false, 'photo', 0, 'User', \Auth::user()->id);
        $upload_url = Config::get('filesystems.disks.qiniu.upload_url');

        return view('admin.user.edit', [
            'user' => $user,
            'token' => $token,
            'upload_url' => $upload_url
        ]);
    }

    /**
     * 用户更新
     */
    public function update(Request $request, $id)
    {
        $somedata = $request->only([
            'account', 'username', 'email', 'phone' , 'summary' , 'sex'
        ]);

        $user = User::findOrFail($id);
        $res = $user->update($somedata);

        // 更新图片（支持图片先上传后保存资料）
        $asset_id = $request->input('asset_id');
        if ($asset_id) {
            $asset = Asset::findOrFail((int)$asset_id);
            $asset->assetable_id = $id;
            $asset->save();
        }

        return redirect('/admin/users');
    }

    /**
     * 删除
     */
    public function destroy(Request $request, $id)
    {
        $res = User::findOrFail($id)->delete();
        
        return redirect('/admin/users');
    }

    /*
* 状态
*/
    public function status(Request $request, $id)
    {
        $ok = User::upStatus($id, 2);
        return redirect('/admin/users');
    }

    public function unstatus(Request $request, $id)
    {
        $ok = User::upStatus($id, 1);
        return redirect('/admin/users');
    }
}
