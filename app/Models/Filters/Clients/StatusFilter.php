<?php

namespace App\Models\Filters\Clients;

use App\Enums\Status;
use Lacodix\LaravelModelFilter\Filters\EnumFilter;

class StatusFilter extends EnumFilter
{
    protected string $field = 'status';

    protected string $enum = Status::class;
}
