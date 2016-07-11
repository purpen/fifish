<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Home\BaseController;

class HomeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home.index');
    }
}
