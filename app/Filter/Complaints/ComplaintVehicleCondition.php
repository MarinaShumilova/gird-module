<?php

namespace App\Filter\Complaints;

use Gird\QueryFilter\QueryCondition;
use Illuminate\Database\Eloquent\Builder;

class ComplaintVehicleCondition implements QueryCondition
{
    public function apply(Builder $query, $value): Builder
    {
        return $query->where('vehicle', 'like' ,"%$value%");
    }
}
