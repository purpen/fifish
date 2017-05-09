<?php

namespace App\Jobs;

use App\Jobs\Job;
use Request;
use IP2City;

class SetLocale extends Job
{
    /**
     * Execute the command.
     *
     * @return void
     */
    public function handle()
    {
		    // 根据IP判断国家，切换语言
        if (!session()->has('locale'))
        {
            session()->put('locale', 'en');
            $area = IP2City::ip2addr(Request::getClientIp());
            if(!empty($area) && is_array($area)) {
                if($area[0] == '中国') {
                    session()->put('locale', 'zh-CN');
                }
            }
            //session()->put('locale', Request::getPreferredLanguage( config('app.languages') ));
        }

        app()->setLocale(session('locale'));
    }
}
