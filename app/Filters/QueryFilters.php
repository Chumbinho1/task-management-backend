<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class QueryFilters
{
    protected $request;

    protected Builder $builder;

    public function __construct(
        Request $request
    )
    {
        $this->request = $request;
    }

    public function apply(
        Builder $builder,
        ?string $prefix = null
    ): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters($prefix) as $name => $value) {
            if (!method_exists($this, $name)) {
                continue;
            }
            if (is_array($value) || strlen($value)) {
                $this->$name($value);
            }
        }

        return $this->builder;
    }

    public function filters(
        ?string $prefix = null
    ): array
    {
        $filters = $this->request->validated();
        if ($prefix) {
            $prefixParts = explode('.', $prefix);
            foreach ($prefixParts as $part) {
                if (!isset($filters[$part])) {
                    return [];
                }

                $filters = $filters[$part];
            }
        }

        return $filters;
    }

    public function getPerPage(): int
    {
        return $this->request->input('perPage', config('app.perPage'));
    }
}
