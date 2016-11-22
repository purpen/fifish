<?php
/**
 * 移动端入口
 * @author purpen
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Models\Column;
use App\Http\Models\ColumnSpace;

class WapController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // 设置菜单状态
        View()->share('show_back_btn', true);
    }
    
    /**
     * 首页.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 获取媒体报道
        $space = ColumnSpace::where('name', 'page_media_news')->first();
        if ($space) {
            
        }
        $columns = $space->columns()->orderBy('created_at', 'desc')->paginate(10);
        
        return view('wap.index', [
            'columns' => $columns,
            'show_back_btn' => false,
        ]);
    }
    
    /**
     * 媒体报道
     */
    public function news()
    {
        $space = ColumnSpace::where('name', 'page_media_news')->first();
        if ($space) {
            
        }
        $columns = $space->columns()->orderBy('created_at', 'desc')->paginate(10);
        
        return view('wap.news', [
            'columns' => $columns
        ]);
    }
    
}
