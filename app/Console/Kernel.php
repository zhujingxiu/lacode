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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('opening:issues')->everyMinute();//正式环境 每秒一次
        $schedule->command('lottery:cqssc')->everyMinute();//正式环境 1分钟一次
        $schedule->command('lottery:xyft')->everyMinute();//正式环境 1分钟一次
        $schedule->command('lottery:pk10')->everyMinute();//正式环境 1分钟一次
        $schedule->command('lottery:jssc')->everyMinute();//正式环境 1分钟一次
        $schedule->command('lottery:jsssc')->everyMinute();//正式环境 1分钟一次
        $schedule->command('lottery:issues')->everyFiveMinutes();//正式环境 5分钟一次

        /**
         * ->cron('* * * * * *');   在自定义的 Cron 时间表上执行该任务
         * ->everyMinute();         每分钟执行一次任务
         * ->everyFiveMinutes();    每5分钟执行一次任务
         * 加入到系统任务中
         * crontab -e
         * [* * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1]
         * 重启crontab
         * cd /etc/init.d
         * ps -aux | grep cron
         * kill -9 999
         * cron start
         */
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
