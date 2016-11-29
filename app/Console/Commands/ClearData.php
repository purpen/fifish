<?php
/**
 * 清理测试数据
 * 
 * @author purpen
 */
namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

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
            DB::table('stuffs')->delete();
            DB::table('taggables')->delete();
            DB::table('tags')->delete();
            DB::table('users')->delete();
        });
        
        $this->info('Clear data is ok!!!');
    }
}
