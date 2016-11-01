<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;

class H5Controller extends BaseController
{
    /**
     * @api {get} /h5/about 关于我们
     * @apiVersion 1.0.0
     * @apiName h5 about 
     * @apiGroup H5
     *
     * @apiSuccessExample 成功响应:
     *   {
     *      page view
     *   }
     */
    public function about(Request $request)
    {
        return view('h5.about');
    }
}
