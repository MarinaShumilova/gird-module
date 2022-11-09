<?php

namespace App\Filter\Complaints;

use Gird\QueryFilter\QueryCondition;
use Illuminate\Database\Eloquent\Builder;

class ComplaintWarrantyCondition implements QueryCondition
{

    public function apply(Builder $query, $value): Builder
    {
        return $query->where('warranty_type_id','like', "$value%");
    }
}
