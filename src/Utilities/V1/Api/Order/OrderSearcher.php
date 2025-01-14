<?php

namespace Callmeaf\Order\Utilities\V1\Api\Order;

use Callmeaf\Base\Utilities\V1\Contracts\SearcherInterface;
use Illuminate\Database\Eloquent\Builder;

class OrderSearcher implements SearcherInterface
{
    public function apply(Builder $query, array $filters = []): void
    {
        $filters = collect($filters)->filter(fn($item) => strlen(trim($item)));
        if($value = $filters->get('ref_code')) {
            $query->where('ref_code',$value);
        }
    }
}
