<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(
        Builder $query,
        QueryFilters $filters,
        ?string $prefix = null
    ): Builder {
        return $filters->apply($query, $prefix);
    }
}
