<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Models\Stuff;
use App\Http\Transformers\StuffTransformer;

class StuffController extends Controller
{
    /**
     * stuff 列表
     */
    public function index() 
    {
        $stuffs = Stuff::with('user','assets')->orderBy('created_at', 'desc')->paginate(2);
        
        return view('admin.stuff.index', ['stuffs' => $stuffs]);
    }
    
    
}
