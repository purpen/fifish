<?php

namespace App\Http\Transformers;

use App\Http\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'account' => $user->account,
            'username' => $user->username,
            'job' => $user->job,
            'sex' => $user->sex,
            'zone' => $user->zone,
            'summary' => $user->summary,
            'follow_count' => $user->follow_count,
            'fans_count' => $user->fans_count,
            'stuff_count' => $user->stuff_count,
            'like_count' => $user->like_count,
            'avatar' => $user->avatar,
            'first_login' => (bool)$user->first_login,
            'following' => $this->following($user, $follow_id),
        ];
    }
    
    /**
     * 是否关注某人
     */
    protected function following(User $user, $follow_id=0)
    {
        $following = false;
        if (!$follow_id) {
            return $following;
        }
        $res = $user->followers()->where('follow_id', $follow_id)->first();
        if ($res) {
            $following = true;
        }
        
        return $following;
    }
    
}