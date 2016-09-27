<?php

namespace App\Http\Transformers;

use App\Http\Models\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id,
            'content' => $comment->content,
            'user' => $comment->user,
            'like_count' => $comment->like_count,
            'reply_user' => $comment->reply_to_user,
        ];
    }
}