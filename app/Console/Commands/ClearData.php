<?php
/**
 * 清理测试数据
 * 
 * @author purpen
 */
namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;
use App\Http\Utils\XSUtil;

class ClearData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear test data';

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
        $this->info('Start to clear data!!!');
        
        // 清理事务
        DB::transaction(function() {
            DB::table('feedback')->delete();
            DB::table('assets')->delete();
            DB::table('columns')->delete();
            DB::table('comments')->delete();
            DB::table('follow')->delete();
            DB::table('likes')->delete();
            DB::table('reminds')->delete();
            DB::table('taggables')->delete();
            DB::table('tags')->delete();
            
            // 清空分享作品
            $stuffs = DB::table('stuffs')->lists('id')->get();
            foreach ($stuffs as $stuff) {
                // 同步删除全文索引
                XSUtil::delIds('Stuff_'.$stuff->id);
                
                DB::table('stuffs')->where('id', $stuff->id)->delete();
            }
            
            // 清空用户
            $users = DB::table('users')->lists('id')->get();
            foreach ($users as $user) {
                // 同步删除全文索引
                XSUtil::delIds('User_'.$user->id);
                
                DB::table('users')->where('id', $user->id)->delete();
            }
            
        });
        
        $this->info('Clear data is ok!!!');
    }
}
