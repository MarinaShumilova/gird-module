<?php

namespace App\Filter\Complaints;

use Gird\QueryFilter\QueryCondition;
use Illuminate\Database\Eloquent\Builder;

class ComplaintExpensesCondition implements QueryCondition
{
    public function apply(Builder $query, $value): Builder
    {
        return $query->whereHas('expenses', function ($q) use ($value) {
            $resultExp = $this->setMonth($value);
            $q->whereIn('start_at', $resultExp);
        });
    }
    private function setMonth(array $dataExpenses): array
    {
        //преобразовать период фильтрации
        return array_map(function ($date) {
            return $date . '-01';
        }, $dataExpenses);
    }
}
