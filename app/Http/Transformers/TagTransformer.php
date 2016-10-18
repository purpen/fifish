<?php

namespace App\Http\Transformers;

use App\Http\Models\Tag;
use Illuminate\Http\Request;

use App\Http\Requests;
use League\Fractal\TransformerAbstract;

class TagTransformer extends TransformerAbstract
{
    public function transform(Tag $tag)
    {
        return [
            'id'  => $tag->id,
            'name' => $tag->name,
            'display_name' => $tag->display_name,
            'cover' => $column->cover,
        ];
    }
}