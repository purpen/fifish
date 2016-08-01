<?php
/**
 * 接口基础控制器
 */
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    // 接口帮助调用
    use Helpers;
    
    // 默认页数
    public $page = 1;
    
    // 默认每页数量
    public $per_page = 10;
    
}
