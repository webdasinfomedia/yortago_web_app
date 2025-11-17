<?php

namespace App\Console;

use App\Console\Commands\LiveStreamReview;
use App\Console\Commands\SendEmail;
use App\Models\User;
use App\Models\UserStreamSession;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Mail;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendEmail::class,
        LiveStreamReview::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {




      $schedule->command(SendEmail::class)->everyFifteenMinutes()->runInBackground()->onOneServer();
       $schedule->command(LiveStreamReview::class)->everyMinute()->runInBackground()->onOneServer();
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
