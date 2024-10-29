<?php

namespace App\Services;

use App\Http\Requests\QueryRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductService
{
    public function __construct(private readonly QueryRequest $queryRequest)
    {
    }

    public function getProductsForView()
    {
        return Product::search($this->queryRequest->getSearchQuery())
            ->filter(allowedFields: [
                'description',
                'categories.title',
                'title'])
            ->sort('description',
                'categories',
                'title')
            ->paginate(10);
    }
}
