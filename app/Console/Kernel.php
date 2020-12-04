<?php

namespace warehouse\Console;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use warehouse\Console\Commands\EnsureQueueListenerIsRunning;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        EnsureQueueListenerIsRunning::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    // protected function schedule(Schedule $schedule)
    // {
    //     // $schedule->call(function () {

    //     //     $dt = Carbon\Carbon::now();

    //     //     $x=60/5;

    //     //     do{

    //     //         $schedule->command('background:process');

    //     //         time_sleep_until($dt->addSeconds(5)->timestamp);

    //     //     } while($x-- > 0);

    //     // })->everyMinute();

    //     $seconds = 5;

    //     $schedule->call(function () use ($seconds) {
    
    //         $dt = Carbon\Carbon::now();
    
    //         $x=60/$seconds;
    
    //         do{
    
    //             $schedule->command('background:process');
    
    //             time_sleep_until($dt->addSeconds($seconds)->timestamp);
    
    //         } while($x-- > 0);
    
    //     })->everyMinute();
    // }


    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        // $schedule->command('backgorund:checkup')->everyMinute();
        // $seconds = 5;

        // $schedule->call(function (Carbon $waktu) use ($seconds) {
    
        //     $dt = $waktu->now();
    
        //     $x=60/$seconds;
    
        //     do{
    
        //         $schedule->command('background:process')->withoutOverlapping();
    
        //         time_sleep_until($dt->addSeconds($seconds)->timestamp);
    
        //     } while($x-- > 0);
    
        // })->everyMinute();
        
        // $schedule->command('background:process')->everyMinute()->withoutOverlapping();
        $schedule->command('workers:webhooks')->everyMinute()->withoutOverlapping();
        // DB::disconnect('devsys3permatacoid');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
