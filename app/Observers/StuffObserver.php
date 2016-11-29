<?php

namespace App\Observers;

use App\Http\Models\Stuff;

use App\Jobs\XSBuildIndex;
use Illuminate\Foundation\Bus\DispatchesJobs;

class StuffObserver
{
    use DispatchesJobs;
    
    /**
     * 创建后，更新所属对象的计数
     */
    public function created ($stuff)
    {   
        // 添加至全文索引
        $idx_job = (new XSBuildIndex($stuff->id, 'Stuff', 'Add'))->onQueue('indexes');
        $this->dispatch($idx_job);
        
        return $stuff->user()->increment('stuff_count');
    }
    
    /**
     * 更新后，更新所属对象事件
     */
    public function updated ($stuff) {
        // 更新全文索引
        $idx_job = (new XSBuildIndex($stuff->id, 'Stuff', 'Update'))->onQueue('indexes');
        $this->dispatch($idx_job);
    }
    
    /**
     * 删除后, 更新所属对象的计数
     */
    public function deleted ($stuff)
    {
        // 从全文索引里删除
        $idx_job = (new XSBuildIndex($stuff->id, 'Stuff', 'Delete'))->onQueue('indexes');
        $this->dispatch($idx_job);
        
        // 限制递减数量
        if ($stuff->stuff_count > 0) {
            return $stuff->user()->decrement('stuff_count');
        }
    }
    
}