<?php

namespace App\Http\Transformers;

use App\Http\Requests;
use App\Http\Models\Like;
use Illuminate\Http\Request;
use League\Fractal\TransformerAbstract;
//use Carbon\Carbon;

use App\Http\Models\Stuff;

class StuffTransformer extends TransformerAbstract
{

    protected $current_user_id;

    public function __construct($options=array())
    {
        $this->current_user_id = isset($options['user_id']) ? (int)$options['user_id'] : 0;
    }

    public function transform(Stuff $stuff)
    {
        return [
            'id' => $stuff->id,
            'content' => $stuff->content,
            'view_count' => $stuff->view_count,
            'kind' => $stuff->kind,
            'city' => $stuff->city,
            'address' => $stuff->address,
            'like_count' => $stuff->like_count,
            'comment_count' => $stuff->comment_count,
            'user_id' => $stuff->user_id,
            'user' => $stuff->user,
            'tags' => $stuff->tags,
            'created_at' => $stuff->created_at->format('Y-m-d'),
            'photo' => $this->photo($stuff),
            'is_love' => $this->is_love($stuff),
        ];
    }
    
    /**
     * 获取照片的信息
     */
    protected function photo($stuff)
    {
        if ($stuff->assets()->count()) {
            return $stuff->assets()->first();
        }
    }

    /**
     * 当前的用户是否点赞此作品
     */
    protected function is_love($stuff)
    {
        $user_id = $this->current_user_id;
        if(empty($user_id)) return false;
        $has_one = Like::where(array('user_id'=>$user_id, 'likeable_id'=>$stuff->id))->first();
        if(!empty($has_one)) return true;
        return false;
    }
    
}
