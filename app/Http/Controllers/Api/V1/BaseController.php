<?php
/**
 * 接口基础控制器
 */
namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use JWTAuth;
use App\Http\Requests;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;

use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;

class BaseController extends Controller
{
    // 接口帮助调用
    use Helpers;
    
    // 默认页数
    public $page = 1;
    
    // 默认每页数量
    public $per_page = 10;
    
    /**
     * 当前登录账号
     */
    protected $auth_user;
    /**
     * 当前登录用户ID
     */
    protected $auth_user_id;
    
    
    /**
     * @param \Illuminate\Http\Request  $request
     */
    public function __construct(Request $request)
    {
        // 装载登录用户
        $this->getAuthUser();
    }
    
    /**
     * 通过Token获取登录用户
     */
    public function getAuthUser ()
    {
        try {
            if ($user = JWTAuth::parseToken()->authenticate()) {
                $this->auth_user = $user;
                $this->auth_user_id = $user->id;
                return;
            }
        } catch (TokenExpiredException $e) {
            // skip
        } catch (TokenInvalidException $e) {
            // skip
        } catch (JWTException $e) {
            // skip
        }
        
        // 设置默认值
        $this->auth_user = [];
        $this->auth_user_id = 1;
    }
}
