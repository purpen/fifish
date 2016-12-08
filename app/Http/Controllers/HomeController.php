<?php
/**
 * 网站的入口文件控制器
 * @author purpen
 */
namespace App\Http\Controllers;

use App;
use Config;
use App\Http\Requests;
use Illuminate\Http\Request;

use App\Http\ApiHelper;

use App\Jobs\ChangeLocale;

use App\Http\Models\User;
use App\Http\Models\Asset;
use App\Http\Models\Column;
use App\Http\Models\ColumnSpace;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        View()->share('lang', true);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        // 获取媒体报道
        $space = ColumnSpace::where('name', 'page_media_news')->first();
        if ($space) {
            
        }
        $columns = $space->columns()->orderBy('created_at', 'desc')->paginate(3);
        
        return view('home', [
            'columns' => $columns
        ]);
    }
    
    
    /**
     * 语言设置
     */
    public function lang($lang, ChangeLocale $changeLocale)
    {
		$lang = in_array($lang, config('app.languages')) ? $lang : config('app.fallback_locale');
        
		$changeLocale->lang = $lang;
        
		$this->dispatch($changeLocale);

		return redirect()->back();
    }
    
    /**
     * 特殊活动展示
     */
    public function promo()
    {
        
    }
}
