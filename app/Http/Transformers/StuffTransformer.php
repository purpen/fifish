<?php

namespace App\Http\Transformers;

use App\Http\Requests;
use Illuminate\Http\Request;
use League\Fractal\TransformerAbstract;

use App\Http\Models\Stuff;

class StuffTransformer extends TransformerAbstract
{
    public function transform(Stuff $stuff)
    {
        return [
            'id' => $stuff->id,
            'content' => $stuff->content,
            'view_count' => $stuff->view_count,
            'kind' => $stuff->kind,
            'like_count' => $stuff->like_count,
            'comment_count' => $stuff->comment_count,
            'user_id' => $stuff->user_id,
            'user' => $stuff->user,
            'tags' => $stuff->tags,
            'photo' => $stuff->cover,
        ];
    }
}
