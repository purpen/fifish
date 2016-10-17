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
            'size' => $asset->size,
            'width' => $asset->width,
            'height' => $asset->height,
            'duration' => $asset->duration,
            'file' => $asset->file,
        ];
    }
}