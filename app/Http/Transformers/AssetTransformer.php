<?php

namespace App\Http\Transformers;

use App\Http\Models\Asset;
use Illuminate\Http\Request;

use App\Http\Requests;
use League\Fractal\TransformerAbstract;

class AssetTransformer extends TransformerAbstract
{
    public function transform(Asset $asset)
    {
        return [
            'id' => $asset->id,
            'size' => ceil($asset->size/1024).'k', // k
            'width' => $asset->width,
            'height' => $asset->height,
            'fileurl' => $asset->fileurl,
        ];
    }
}