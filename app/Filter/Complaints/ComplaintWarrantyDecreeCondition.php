<?php

namespace App\Filter\Complaints;

use Gird\QueryFilter\QueryCondition;
use Illuminate\Database\Eloquent\Builder;

class ComplaintWarrantyDecreeCondition implements QueryCondition
{

    public function apply(Builder $query, $value): Builder
    {
        return $query->where('warranty_decree', 'like' ,"$value%");
    }
}
