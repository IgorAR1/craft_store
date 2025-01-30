<?php

namespace App\Http\Controllers\Api\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\File;
use App\Models\Product;
use App\Services\ProductService;
use App\Services\Files\ImageAdder;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
        readonly ImageAdder $imageAdder)
    {}

    public function index()
    {
        $products = $this->productService->getProductsForView();

        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(ProductCreateRequest $request)
    {
        $data = $request->validated();

        $product = $this->productService->createProduct($data);

        return response(new ProductResource($product->load('categories')),201);
    }

    public function update(ProductUpdateRequest $request,Product $product){

        $data = $request->validated();

        $this->productService->updateProduct($product, $data);

        return new ProductResource($product);
    }

    public function delete(Product $product){
        $product->delete();

        return response(status: 203);
    }

}
