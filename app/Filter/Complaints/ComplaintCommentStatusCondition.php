<?php

namespace App\Filter\Complaints;

use Gird\QueryFilter\QueryCondition;
use Illuminate\Database\Eloquent\Builder;

class ComplaintCommentStatusCondition implements QueryCondition
{
   public function apply(Builder $query, $value): Builder
  {
      return $query->whereHas('commentstatuses', function ($q) use ($value) {
          $q->where('comment', 'like', "%$value%");
      });

  }
}
