<?php

namespace App\Filter\Complaints;


use Gird\QueryFilter\QueryCondition;
use Illuminate\Database\Eloquent\Builder;


class ComplaintChassisCondition implements QueryCondition
{
    public function apply(Builder $query, $value): Builder
    {
        return $query->whereHas('chassises', function ($q) use ($value) {
            $q->where('number', 'like', "%$value%");
        });
    }
}
