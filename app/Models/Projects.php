<?php

namespace App\Models;

use App\Enums\Status as StatusEnum;
use App\Models\Filters\Projects\Status as StatusFilter;
use App\Models\Scopes\MyOwnRecordScope;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lacodix\LaravelModelFilter\Traits\HasFilters;
use Lacodix\LaravelModelFilter\Traits\IsSearchable;

class Projects extends Model
{
    use HasFactory, HasFilters, HasUuids, IsSearchable;

    protected $fillable = [
        'user_id',
        'clients_id',
        'name',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clients(): BelongsTo
    {
        return $this->belongsTo(Clients::class);
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'status' => StatusEnum::class,
        ];
    }

    protected array $searchable = [
        'name',
    ];

    protected array $filters = [
        StatusFilter::class,
    ];

    /**
     * The "booted" method of the model for Global scope.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new MyOwnRecordScope);
    }
}
