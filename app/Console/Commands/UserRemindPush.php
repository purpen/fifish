<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use Log;
use Config;
use App\Http\Utils\JPushUtil;

class UserRemindPush extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:user_remind';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'JPush User Remind';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Log::debug(sprintf('user remind push job!'));

        $page = 1;
        $size = 100;
        $is_end = false;
        $total = 0;

        $select = array('id','status','created_at','account','alert_comment_count','alert_like_count','alert_fans_count');

        while(!$is_end){
            $query = array('status'=>2);
            $options = array('page'=>$page,'size'=>$size);
            $skip = ($page-1) * $size;
            $users = DB::table('users')->where($query)->orderBy('created_at', 'desc')->select($select)->take($size)->skip($skip)->get();
            $users = json_decode(json_encode( $users),true);

            if(empty($users)){
                Log::debug(sprintf('users is empty! break'));
                break;
            }
            $max = count($users);
            for ($i=0; $i < $max; $i++) {
                $user = $users[$i];
                if($user['alert_fans_count']>0){
                    $ok = $this->push($user['id'], $user['alert_fans_count'], 1);
                }elseif($user['alert_comment_count']>0){
                    $ok = $this->push($user['id'], $user['alert_comment_count'], 2);
                }elseif($user['alert_like_count']>0){
                    $ok = $this->push($user['id'], $user['alert_like_count'], 3);
                }else{
                    $ok = false;
                }

                // 测试
                //$ok = $this->push(49, 3, 3);

                if($ok) $total++;
            }   // endfor
            if($max < $size){
                Log::debug('users is end. exit!');
                break;
            }
            $page++;
        }   // end while

        Log::debug(sprintf("user remind push pubish! count: %d.", $total));
    }


    /**
     * 执行推送
     * @param user_id, count, type
     * @return $ok
     */
    protected function push($user_id, $count, $type=1)
    {

        $alert = '';
        switch($type){
            case 1:
                $alert = sprintf("您又增加了%d位粉丝,快来查看吧!", $count);
                break;
            case 2:
                $alert = sprintf("收到了%d条评论,快来查看吧!", $count);
                break;
            case 3:
                $alert = sprintf("收到了%d条赞,快来查看吧!", $count);
                break;
        }
        $options = array();
        $options['platform'] = array('ios','android');
        $options['alias'] = array((string)$user_id);
        $options['extras'] = array('infoType'=>8, 'infoId'=>1);
        //$options['addAllAudience'] = true;
        $ok = JPushUtil::send($alert, $options);
        
        return $ok;
    }

}
