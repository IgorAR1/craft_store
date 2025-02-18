<?php

namespace App\Http\Controllers\Api\Product;

use App\Enums\ActionType;
use App\Factories\DiscountRulesFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Discount;
use App\Models\DiscountAction;
use App\Models\DiscountRule;
use App\Models\Product;
use App\Services\ActivityLogger;
use App\Services\Discount\DiscountProcessor;
use App\Contracts\RuleChecker;
use App\Services\ProductService;
use App\Services\Files\ImageAdder;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function __construct(
        private readonly ProductService $productService,
        readonly ImageAdder             $imageAdder,
        readonly DiscountProcessor      $discountService,
    )
    {}

    public function index():JsonResource
    {

//        Discount::first()->action()->sync(DiscountAction::all());
//        Discount::first()->rule()->sync(DiscountRule::all());
//dd();
        $this->discountService->process(Product::query()->first());
        $products = $this->productService->getProductsForView();

        return ProductResource::collection($products);
    }

    public function show(Product $product):JsonResource
    {
        return new ProductResource($product);
    }

    public function store(ProductCreateRequest $request):Response
    {
        $data = $request->validated();

        $product = $this->productService->createProduct($data);

        return response(new ProductResource($product->load('categories')),201);
    }

    public function update(ProductUpdateRequest $request,Product $product):JsonResource
    {
        $data = $request->validated();

        $this->productService->updateProduct($product, $data);

        return new ProductResource($product);
    }

    public function delete(Product $product):Response
    {
        $product->delete();

        return response(status: 203);
    }

}
