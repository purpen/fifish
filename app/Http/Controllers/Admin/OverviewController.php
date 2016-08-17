<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

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
        return view('admin.index');
    }
}
