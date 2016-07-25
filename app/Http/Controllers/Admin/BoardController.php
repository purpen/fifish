<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BoardController extends Controller
{
    /**
     * 后台管理入口
     */
    public function index()
    {
        return view('admin/index');
    }
}
