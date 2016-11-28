<?php

namespace App\Jobs;

use Log;
use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Http\Models\Stuff;
use App\Http\Models\User;
use App\Http\Utils\XSUtil;

class XSBuildIndex extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    /**
     * 目标对象
     */
    protected $target_id = 0;
    
    /**
     * 对象类型 (Stuff、User)
     */
    protected $type = 'Stuff';
    
    /**
     * 操作动作（Add、Update、Delete)
     */
    protected $operate = 'Add';
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($target_id, $type='Stuff', $operate='Add')
    {
        $this->target_id = $target_id;
        $this->type = $type;
        $this->operate = $operate;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug(sprintf('Build [%s][%s][%d] index job!', $this->operate, $this->type, $this->target_id));
        
        switch ($this->operate) {
            case 'Add':
                $data = $this->build_data();
                if (!empty($data)) {
                    
                    XSUtil::add($data);
                }
                break;
            case 'Update':
                $data = $this->build_data();
                if (!empty($data)) {
                    XSUtil::update($data);
                }
                break;
            default:
                $key = $this->type.'_'.$this->target_id;
                XSUtil::delIds($key);
                break;
        }
        
        return true;
    }
    
    protected function build_data()
    {
        $data = array();
        switch ($this->type) {
            case 'Stuff':
                $stuff = Stuff::find($this->target_id);
                if (!empty($stuff)) {
                    // 组合标签
                    $max = count($stuff->tags);
                    $tags = '';
                    for ($i=0; $i<$max; $i++) {
                        $tags .= $stuff->tags[$i]->name.' '.$stuff->tags[$i]->display_name;
                    }
                    
                    $data = array(
                        'oid' => $stuff->id,
                        'pid' => 'Stuff_'.$stuff->id,
                        'kind' => 'Stuff',
                        'cid' => 0,
                        'tid' => $stuff->kind,
                        'user_id' => $stuff->user_id,
                        'user_name' => $stuff->user->username,
                        'title' => '',
                        'content' => $stuff->content,
                        'body' => '',
                        'tags' => $tags,
                        'cover_id' => $stuff->cover ? $stuff->cover->id : 0,
                        'created_on' => $stuff->created_at,
                        'updated_on' => $stuff->updated_at,
                    );
                }
                break;
            case 'User':
                $user = User::find($this->target_id);
                if (!empty($user)) {
                    $data = array(
                        'oid' => $user->id,
                        'pid' => 'User_'.$stuff->id,
                        'kind' => 'User',
                        'cid' => 0,
                        'tid' => 0,
                        'user_id' => $user->id,
                        'user_name' => $user->username,
                        'title' => '',
                        'content' => $user->summary,
                        'body' => '',
                        'tags' => $user->tags,
                        'cover_id' => $user->avatar ? $user->avatar->id : 0,
                        'created_on' => $user->created_at,
                        'updated_on' => $user->updated_at,
                    );
                }
                break;
        }
        
        return $data;
    }
    
}
