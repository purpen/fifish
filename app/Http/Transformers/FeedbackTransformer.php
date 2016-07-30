<?php

namespace App\Http\Transformers;

use App\Http\Models\Feedback;
use Illuminate\Http\Request;

use App\Http\Requests;
use League\Fractal\TransformerAbstract;

class FeedbackTransformer extends TransformerAbstract
{
    public function transform(Feedback $feedback)
    {
        return [
            'contact' => $feedback->contact,
            'content' => $feedback->content,
        ];
    }
}