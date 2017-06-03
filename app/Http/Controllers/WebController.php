<?php
/**
 * 网站的静态文件控制器
 * @author purpen
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Models\Column;
use App\Http\Models\ColumnSpace;

class WebController extends Controller
{
    /**
     * 媒体报道
     */
    public function news()
    {
        $columns = [];
        
        $space = ColumnSpace::where('name', 'page_media_news')->first();
        if ($space) {
            $columns = $space->columns()->orderBy('created_at', 'desc')->paginate(10);
        }
        
        return view('web.news', [
            'columns' => $columns, 'sub_menu_news' => 'active',
        ]);
    }
    
    /**
     * 关于我们.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutUs()
    {        
        return view('web.aboutus', ['sub_menu_aboutus' => 'active']);
    }
    
    /**
     * 联系方式
     */
    public function contact()
    {        
        return view('web.contact', ['sub_menu_contact' => 'active']);
    }

    /**
     * 招募
     */
    public function recruit()
    {        
        return view('web.recruit', ['sub_menu_recruit' => 'active']);
    }
    
    /**
     * P4
     */
    public function p4()
    {        
        return view('web.p4', ['sub_menu_p4' => 'active']);
    }
    
    
}
