<?php

namespace App\Models\Filters\Clients;

use App\Enums\CurrencyCode;
use Lacodix\LaravelModelFilter\Filters\EnumFilter;

class Currency extends EnumFilter
{
    protected string $field = 'status';

    protected string $enum = CurrencyCode::class;
}
