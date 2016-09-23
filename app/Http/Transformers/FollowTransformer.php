<?php

namespace App\Http\Transformers;

use App\Http\Models\User;
use App\Http\Models\Follow;
use Illuminate\Http\Request;

use App\Http\Requests;
use League\Fractal\TransformerAbstract;

class FollowTransformer extends TransformerAbstract
{
    protected $current_user_id;

    public function __construct($options=array())
    {
        $this->current_user_id = isset($options['user_id']) ? (int)$options['user_id'] : 0;
    }

    public function transform(Follow $follow)
    {
        return [
            'id' => $follow->id,
            'user_id' => $follow->user_id,
            'user' => $follow->user,
            'follow_id' => $follow->follow_id,
            'follower' => $follow->follower,
            'is_follow' => $this->is_follow($follow),
        ];
    }

    /**
     * 当前的用户是否关注此用户
     */
    protected function is_follow($follow)
    {
        $user_id = $this->current_user_id;
        if(empty($user_id)) return false;
        $has_one = Follow::where(array('user_id'=>$user_id, 'follow_id'=>$follow->user_id))->first();
        if(!empty($has_one)) return true;
        return false;
    }

}
