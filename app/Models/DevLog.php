<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevLog extends Model
{
    protected $fillable = [
        'message',
        'log_date',
    ];

    protected function casts(): array
    {
        return [
            'log_date' => 'date',
        ];
    }
}
