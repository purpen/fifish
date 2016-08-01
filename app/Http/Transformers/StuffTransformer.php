<?php

namespace App\Http\Transformers;

use App\Http\Models\Stuff;
use Illuminate\Http\Request;

use App\Http\Requests;
use League\Fractal\TransformerAbstract;

class StuffTransformer extends TransformerAbstract
{
    public function transform(Stuff $stuff)
    {
        return [
            'id' => $stuff->id,
            'content' => $stuff->content,
            'user_id' => $stuff->user_id,
            'user' => $stuff->user,
            'tags' => $stuff->tags,
            'asset_id' => $stuff->asset_id
        ];
    }
}