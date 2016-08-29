<?php
/**
 * 网站的静态文件控制器
 * @author purpen
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class WebController extends Controller
{
    /**
     * 关于我们.
     *
     * @return \Illuminate\Http\Response
     */
    public function aboutUs()
    {
        return view('web.aboutus');
    }
    
    /**
     * 联系方式
     */
    public function contact()
    {
        return view('web.contact');
    }
    
    
    
}
