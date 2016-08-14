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
            'photo' => $this->photo($stuff),
        ];
    }
    
    /**
     * 获取照片的信息
     */
    protected function photo($stuff)
    {
        if ($stuff->assets()->count()) {
            $assetTransformer = new AssetTransformer();
            return $assetTransformer->transform($stuff->assets()->first());
        }
    }
    
}