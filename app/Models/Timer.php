<?php

namespace App\Models;

use App\Enums\TimerStatusEnums;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Timer extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'clients_id',
        'projects_id',
        'duration',
        'status',
        'timer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clients(): BelongsTo
    {
        return $this->belongsTo(Clients::class);
    }

    public function projects(): BelongsTo
    {
        return $this->belongsTo(Projects::class);
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'status' => TimerStatusEnums::class,
            'timer' => 'array',
        ];
    }
}
