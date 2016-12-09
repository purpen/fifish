<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\Inspire::class,
        // 用户消息推送
        Commands\UserRemindPush::class,
        'App\Console\Commands\ClearData',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        // 用户消息推送
        $schedule->command('push:user_remind')->cron('0,30 8-23 * * *'); // 在每天上午8点到23点期间每5分钟触发 

    }
}
