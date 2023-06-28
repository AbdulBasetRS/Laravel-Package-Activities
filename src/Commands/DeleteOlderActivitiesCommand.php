<?php

namespace Abdulbaset\Activities\Commands;

use Illuminate\Console\Command;
use Abdulbaset\Activities\Models\ActivityLog;

class DeleteOlderActivitiesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-older-activities-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = config('ActivityConfig.delete_records_older_than_days');
        
        $date = now()->subDays($days)->toDateTimeString();
        
        $count = ActivityLog::where('created_at', '<', $date)->delete();
        
        $this->info("Deleted ".$count." activities older than ".$days." days.");
    }
}
