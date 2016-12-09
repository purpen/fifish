<?php
/**
 * 极光推送
 */
namespace App\Http\Utils;

use Log;
use Config;
use JPush\Client as JPush;

class JPushUtil
{

	/**
	 * 验证索引索引服务器是否启动
	 */
    public static function send($alert, $options=array())
    {

        $alert = trim($alert);
        // ios
        $sound = isset($options['sound']) ? $options['sound'] : 'default';
        $badge = isset($options['badge']) ? $options['badge'] : null;
        $contentAvailable = isset($options['contentAvailable']) ? $options['contentAvailable'] : false;
        $category = isset($options['category']) ? $options['category'] : null;

        // android
        $title = isset($options['title']) ? $options['title'] : null;
        $builderId = isset($options['builderId']) ? (int)$options['builderId'] : null;

        // win phone
        $_open_page = isset($options['_open_page']) ? $options['_open_page'] : null;

        // common
        $platform = isset($options['platform']) ? (array)$options['platform'] : array();
        $addAllAudience = isset($options['addAllAudience']) ? $options['addAllAudience'] : false;

        $tags = isset($options['tags']) ? (array)$options['tags'] : array();
        $alias = isset($options['alias']) ? (array)$options['alias'] : array();
        $regId = isset($options['regId']) ? (array)$options['regId'] : array();
        $extras = isset($options['extras']) ? (array)$options['extras'] : array();
        $sendNo = isset($options['sendNo']) ? (int)$options['sendNo'] : null;
        $timeToLive = isset($options['timeToLive']) ? (int)$options['timeToLive'] : 86400;  // 默认1天
        $overrideMsgId = isset($options['overrideMsgId']) ? (int)$options['overrideMsgId'] : null;
        $apnsProduction = isset($options['apnsProduction']) ? $options['apnsProduction'] : false;
        $bigPushDuration = isset($options['bigPushDuration']) ? (int)$options['bigPushDuration'] : null;


        $app_key = Config::get('jpush.app_key');
        $master_secret = Config::get('jpush.master_secret');
        $client = new JPush($app_key, $master_secret);
        $pusher = $client->push();


        $ios_notification = array(
            'sound' => $sound,
            'badge' => $badge,
            'content-available' => $contentAvailable,
            'category' => $category,
            'extras' => $extras,
        );
        $android_notification = array(
            'alert' => $alert,
            'build_id' => $builderId,
            'extras' => $extras,
        );
        $content = $alert;
        $message = array(
            'alert' => $alert,
            'content_type' => 'text',
            'extras' => $extras,
        );
        $option = array(
            'sendno' => $sendNo,
            'time_to_live' => $timeToLive,
            'override_msg_id' => $overrideMsgId,
            'apns_production' => $apnsProduction,
            'big_push_duration' => $bigPushDuration
        );

        try {
            $pusher->setPlatform($platform);
            if($addAllAudience){    // 广播推送
                $pusher->addAllAudience();
            }else{  // 定制推送
                if($tags){
                    $pusher->addTag($tags);
                }
                if($regId){
                    $pusher->addRegistrationId($regId);
                }
                if($alias){
                    $pusher->addAlias($alias);
                }           
            }
            $pusher->iosNotification($alert, $ios_notification);
            $pusher->androidNotification($alert, $android_notification);
            $pusher->options($option);

            $response = $pusher->send();
        } catch (\JPush\Exceptions\JPushException $e) {
            // try something else here
            print $e;
        }

	}

    
}
