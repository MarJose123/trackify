<?php

namespace App\Models;

use App\Enums\BillingMethod;
use App\Enums\CurrencyCode;
use App\Enums\Status;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Clients extends Model
{
    use HasFactory, HasUuids;

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
        'status' => Status::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
