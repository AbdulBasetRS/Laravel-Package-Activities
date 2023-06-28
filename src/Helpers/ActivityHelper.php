<?php

use Abdulbaset\Activities\Models\ActivityLog;

function ActivityHellper_Test($param) {
    return '- From Activity Hellper | ' . strtoupper($param) ;
}

function delete_records_older_than_days() {
    $days = config('ActivityConfig.delete_records_older_than_days');
        
    $date = now()->subDays($days)->toDateTimeString();
    
    $count = ActivityLog::where('created_at', '<', $date)->delete();
}

