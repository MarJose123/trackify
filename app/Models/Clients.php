<?php

namespace App\Models;

use App\Enums\BillingMethod;
use App\Enums\CurrencyCode;
use App\Enums\Status as StatusEnum;
use App\Models\Filters\Clients\Currency as CurrencyFilter;
use App\Models\Filters\Clients\Status as StatusFilter;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lacodix\LaravelModelFilter\Traits\HasFilters;
use Lacodix\LaravelModelFilter\Traits\IsSearchable;

class Clients extends Model
{
    use HasFactory, HasFilters, HasUuids, IsSearchable;

    protected $fillable = [
        'user_id',
        'name',
        'currency',
        'billing_method',
        'company_name',
        'rate',
        'status',
    ];

    protected $casts = [
        'currency' => CurrencyCode::class,
        'billing_method' => BillingMethod::class,
        'status' => StatusEnum::class,
    ];

    protected array $filters = [
        CurrencyFilter::class,
        StatusFilter::class,
    ];

    protected array $searchable = [
        'company_name',
        'name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
