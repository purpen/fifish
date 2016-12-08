<?php
/**
 * 移动端入口
 * @author purpen
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Models\Stuff;
use App\Http\Models\Column;
use App\Http\Models\ColumnSpace;

use App\Jobs\ChangeLocale;

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
    
    /**
     * H5显示分享Url
     */
    public function stuff(Request $request, $id)
    {
        $stuff = Stuff::find($id);
        
        // 推荐相关的
        $relate_stuffs = Stuff::featured()->orderBy(\DB::raw('RAND()'))->take(12)->get();
        
        return view('wap.stuff',[
            'stuff' => $stuff,
            'relate_stuffs' => $relate_stuffs,
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
    
    
}
