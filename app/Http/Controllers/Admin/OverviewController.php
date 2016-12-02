<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\User;
use App\Http\Models\Stuff;
use App\Http\Models\Like;
use App\Http\Models\Comment;

class OverviewController extends Controller
{
    public function __construct()
    {
        // 设置菜单状态
        View()->share('sitebar_menu_overview', 'active');
    }
    /**
     * 后台管理入口
     */
    public function index()
    {
        // 获取用户的数量
        $user_total = User::all()->count();
        // 分享数量
        $stuff_total = Stuff::all()->count();
        // 点赞数量
        $like_total = Like::all()->count();
        // 评论数量
        $comment_total = Comment::all()->count();
        
        
        return view('admin.index', [
            'user_total' => $user_total,
            'stuff_total' => $stuff_total,
            'like_total' => $like_total,
            'comment_total' => $comment_total,
        ]);
    }
}
