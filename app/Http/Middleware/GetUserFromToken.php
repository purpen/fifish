<?php
/**
 * Api身份验证
 * 在定义 Api 返回内容时，特别是错误返回码时，特别注意一定要制定好统一的返回值格式
 *
 * @author purpen
 */
namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

use App\Http\ApiHelper;

class GetUserFromToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(ApiHelper::error('User not found!', 404));
            }
        } catch (TokenExpiredException $e) {
            return response()->json(ApiHelper::error('Token expired!', 401));
        } catch (TokenInvalidException $e) {
            return response()->json(ApiHelper::error('Token invalid!', 403));
        } catch (JWTException $e) {
            return response()->json(ApiHelper::error('Token absent!', 402));
        }
        
        return $next($request);
    }
}