<?php

namespace App\Http\Transformers;

use App\Http\Models\Like;
use Illuminate\Http\Request;

use App\Http\Requests;
use League\Fractal\TransformerAbstract;
use App\Http\Transformers\StuffTransformer;

class LikeTransformer extends TransformerAbstract
{
    public function transform(Like $like)
    {
        return [
            'id' => $like->id,
            'likeable' => $like->likeable,
            'user' => $like->user,
        ];
    }
    
}