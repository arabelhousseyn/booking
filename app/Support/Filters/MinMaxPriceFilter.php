<?php

namespace App\Support\Filters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class MinMaxPriceFilter implements Filter
{

    public function __invoke(Builder $query, $value, string $property): void
    {
        $query->whereBetween('price', $value);
    }
}
