<?php
return [
    'activity_enabled' => env('ACTIVITY_ENABLED', true),
    'table_name' => 'activities',
    'submit_empty_logs' => true,
    'log_only_changes' => true,
    'delete_records_older_than_days' => 365,
    'visited' => true,
    'crud_operation' => [
        'create' => true,
        'read' => true,
        'update' => true,
        'delete'=> true,
    ],
    'operation_info' => [
        'ip' => true,
        'browser' => true,
        'browser_version' => true,
        'referring_url' => true ,
        'current_url' => true,
        'device_type' => true,
        'operating_system' => true
    ],
    'exclude_column' => [
        // 'created_at', 
        // 'updated_at' , 
        // 'deleted_at',
        // 'password',
        // 'other',
    ],
];