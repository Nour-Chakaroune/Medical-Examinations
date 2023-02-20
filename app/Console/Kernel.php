<?php

namespace App\Console;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            DB::table('user_permission')->where('deadline', '<=', now()->format('DD/MM/YYYY hh:mm A'))->delete();
        })->everyMinute();

        $schedule->call(function () {
            DB::table('task')->whereDate('date', '<=', now()->subDays(60))->delete();
        })->monthly();

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
