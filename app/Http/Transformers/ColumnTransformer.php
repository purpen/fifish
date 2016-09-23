<?php

namespace App\Http\Transformers;

use App\Http\Requests;
use Illuminate\Http\Request;
use League\Fractal\TransformerAbstract;
//use Carbon\Carbon;

use App\Http\Models\Column;

class ColumnTransformer extends TransformerAbstract
{

    protected $current_user_id;

    public function __construct($options=array())
    {
        $this->current_user_id = isset($options['user_id']) ? (int)$options['user_id'] : 0;
    }

    public function transform(Column $column)
    {
        return [
            'id' => $column->id,
            'title' => $column->title,
            'sub_title' => $column->sub_title,
            'content' => $column->content,
            'summary' => $column->summary,
            'column_space_id' => $column->column_space_id,
            'type' => $column->type,
            'evt' => $column->evt,
            'url' => $column->url,
            'cover_id' => $column->cover_id,
            'cover' => $column->cover,
            'status' => $column->status,
            'order' => $column->order,
            'view_count' => $column->view_count,
            'created_at' => $column->created_at->format('Y-m-d'),
        ];
    }

}
