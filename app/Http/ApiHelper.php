<?php
    
namespace App\Http;

class ApiHelper
{
    /**
     * 响应正确信息
     * @param string $message 响应提示信息
     * @param int $code 响应状态码
     * @param $data 响应数据
     *
     * @return Array
     */
    static public function success($message='Success.', $status_code=200, $data=array())
    {
        $result['meta'] = array(
            'message' => $message,
            'status_code' => $status_code
        );
        
        if (!empty($data)) {
            $result['data'] = $data;
        }
        
        return $result;
    }
    
    /**
     * 保持返回json格式一致
     * @param string $message 响应提示信息
     * @param int $code 响应状态码
     *
     * @return Array
     */
    static public function meta($message='Success.', $status_code=200)
    {
        return [
            'message' => $message,
            'status_code' => $status_code
        ];
    }
    
    /**
     * 响应错误信息
     * @param string $message 响应提示信息
     * @param int $code 响应状态码
     *
     * @return Array
     */
    static public function error($message='Error!', $status_code=200)
    {
        $result['meta'] = array(
            'message' => $message,
            'status_code' => $status_code
        );
        
        return $result;
    }
    
    static public function urlsafe_b64decode($string) {
       $data = str_replace(array('-', '_'), array('+', '/'), $string);
       $mod4 = strlen($data) % 4;
       if ($mod4) {
           $data .= substr('====', $mod4);
       }
       
       return base64_decode($data);
    }
    
    
}