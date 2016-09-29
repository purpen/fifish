<?php

namespace App\Http\Transformers;

use App\Http\Models\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;
use League\Fractal\TransformerAbstract;
use App\Http\Utils\DateModifier;

class CommentTransformer extends TransformerAbstract
{
    public function transform(Comment $comment)
    {
        return [
            'id' => $comment->id,
            'content' => $comment->content,
            'user' => $comment->user,
            'like_count' => $comment->like_count,
            'reply_user' => !empty($comment->reply_to_user) ? $comment->reply_to_user : null,
            'created_at' => DateModifier::relative_datetime($comment->created_at->getTimestamp()),
        ];
    }
}
