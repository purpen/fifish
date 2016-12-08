<?php

namespace App\Http\Transformers;

use App\Http\Models\Remind;
use League\Fractal\TransformerAbstract;

class RemindTransformer extends TransformerAbstract
{
    public function transform(Remind $remind)
    {
        if ($remind->evt == 2) {
            $content = $remind->remindable()->first()->content;
        } else {
            $content = $remind->content;
        }
        
        $related = $remind->stuff()->first();
        $stuff = [
            'id' => $related->id,
            'kind' => $related->kind,
            'cover' => $related->cover,
        ];
        
        return [
            'id' => $remind->id,
            'evt' => $remind->evt_label,
            'content' => $content,
            'sender' => $remind->sender,
            'stuff' => $stuff,
            'created_at' => $remind->created_at->format('Y-m-d'),
        ];
    }
    
}