<?php

namespace App\Services;

use App\Enums\SqlOperators;
use App\Factories\FilterFactory;
use App\Http\Requests\QueryRequest;
use App\Models\Product;

class ProductService
{
    public function __construct(readonly QueryRequest $queryRequest,readonly FilterFactory $filterFactory)
    {
    }

    public function getProductsForView()
    {
        $filterFactory = $this->filterFactory;

        return Product::search($this->queryRequest->getSearchQuery())
            ->filter([
                'price' => $filterFactory->createExactFilter(),
                'price_min' => $filterFactory->createRangeFilter(SqlOperators::GREATER_THAN),
                'price_max' => $filterFactory->createRangeFilter(SqlOperators::LESS_THAN),
            ])
            ->sort('description',
                'categories',
                'title')
            ->paginate(10);
    }
}
