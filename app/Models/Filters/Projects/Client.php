<?php

namespace App\Models\Filters\Projects;

use Illuminate\Database\Eloquent\Builder;
use Lacodix\LaravelModelFilter\Enums\FilterMode;
use Lacodix\LaravelModelFilter\Filters\StringFilter;

class Client extends StringFilter
{
    public FilterMode $mode = FilterMode::EQUAL;

    protected string $field = 'clients_id';

    /**  column of the relation */
    protected string $relation = 'clients';

    /** relation name : where the search will be applied */
    public function apply(Builder $query): Builder
    {
        return $query->whereHas($this->relation, function (Builder $query) {
            $query->where($this->field, $this->values[$this->field]);
        });
    }
}
