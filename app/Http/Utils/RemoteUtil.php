<?php
    
namespace App\Http\Utils;

use Log;

class RemoteUtil
{
    /**
     * 发起GET请求
     */
    public static function getReqest($url)
    {
        if (empty($url)){
            return;
        }
        
        $ch = curl_init();
        // 设置选项
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        // 执行并获取结果
        $result = curl_exec($ch);
        if ($result === FALSE) {
            Log::warn('cURL Error: '.curl_error($ch));
            return;
        }
        // 释放curl句柄
        curl_close($ch);
        
        return $result;
    }
}