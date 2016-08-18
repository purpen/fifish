<?php

namespace App\Http\Transformers;

use App\Http\Models\User;
use App\Http\Models\Follow;
use Illuminate\Http\Request;

use App\Http\Requests;
use League\Fractal\TransformerAbstract;

class FollowTransformer extends TransformerAbstract
{
    public function transform(Follow $follow)
    {
        return [
            'id' => $follow->id,
            'user_id' => $follow->user_id,
            'user' => $follow->user,
            'follow_id' => $follow->follow_id,
            'follower' => $follow->follower,
        ];
    }
}