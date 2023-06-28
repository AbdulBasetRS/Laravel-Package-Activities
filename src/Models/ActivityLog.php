<?php

namespace Abdulbaset\Activities\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('ActivityConfig.table_name');
    }

    protected $fillable = [
        'event',
        'user_id',
        'model',
        'model_id',
        'old',
        'new',
        'ip',
        'browser',
        'browser_version',
        'referring_url',
        'current_url',
        'device_type',
        'operating_system',
        'description'
    ];
}
