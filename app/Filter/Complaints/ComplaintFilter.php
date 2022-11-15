<?php

namespace App\Filter\Complaints;

use Gird\QueryFilter\QueryFilter;

class ComplaintFilter extends QueryFilter
{
    protected $conditions = [
                'status_filter' =>ComplaintStatusCondition::class,
                'data_expenses'=>ComplaintExpensesCondition::class,
                'warranty_types'=>ComplaintWarrantyCondition::class,
                'search'=>ComplaintSearchCondition::class,
                'contractor_search'=>ComplaintContractorCondition::class,
                'warranty_decree_filter'=>ComplaintWarrantyDecreeCondition::class,
    ];
}
