<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\User;
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
     * 删除
     */
    public function destroy(Request $request, $id)
    {
        $res = User::findOrFail($id)->delete();
        
        return redirect('/admin/users');
    }
}
