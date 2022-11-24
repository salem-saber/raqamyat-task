<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use PaymentApp\Commands\ApiKeyGenerateCommand;
use PaymentApp\Commands\InsertProviderData;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ApiKeyGenerateCommand::class,
        InsertProviderData::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('insert:provider-data')->daily()->runInBackground();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
