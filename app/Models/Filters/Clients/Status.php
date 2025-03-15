<?php

namespace App\Models\Filters\Clients;

use App\Enums\Status as StatusEnum;
use Lacodix\LaravelModelFilter\Filters\EnumFilter;

class Status extends EnumFilter
{
    protected string $field = 'status';

    protected string $enum = StatusEnum::class;
}
