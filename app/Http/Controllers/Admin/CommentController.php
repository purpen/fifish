<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Asset;

class CommentController extends Controller
{
    public function __construct()
    {
        // 设置菜单状态
        View()->share('sitebar_menu_comments', 'active');
    }
    
    /**
     * 附件列表
     */
    public function index() 
    {
        
    }
    
    /**
     * 关闭评论
     */
    public function destroy()
    {
        
    }
    
}
