<?php

namespace App\Console;

use App\Console\Commands\DbBackup;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
         $schedule->command('db:backup')->everyFiveMinutes();

    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        DbBackup::class;

        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
