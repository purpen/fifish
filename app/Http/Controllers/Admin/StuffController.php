<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class StuffController extends Controller
{
    
    /**
     * stuff 列表
     */
    public function index() 
    {
        $stuffs = StuffModel::all();
        
        foreach ($stuffs as $stuff) {
            echo $stuff->description;
        }
        
        return view('admin/stuff/index', ['stuffs' => $stuffs]);
    }
}
