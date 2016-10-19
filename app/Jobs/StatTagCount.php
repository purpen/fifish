<?php
/**
 * 统计标签被使用次数的任务
 */
namespace App\Jobs;

use DB;
use Log;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StatTagCount extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;
    
    protected $tag_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($tag_id)
    {
        $this->tag_id = (int)$tag_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('Start Job tag '.$this->tag_id);
        
        $affected = DB::update('UPDATE `tags` as a LEFT JOIN `taggables` as b on a.id=b.tag_id SET a.total_count=(SELECT COUNT(tag_id) FROM `taggables` WHERE tag_id='.$this->tag_id.') WHERE a.id='.$this->tag_id);
        
        Log::debug('Update tag ['.$this->tag_id.'], count ['.$affected.'].');
    }
    
}
