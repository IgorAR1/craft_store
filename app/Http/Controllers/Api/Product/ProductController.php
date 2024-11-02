<?php

namespace App\Http\Controllers\Api\Product;

use App\Facades\Elasticsearch;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Searchers\ElasticSearch\ElasticSearcher;
use App\Services\ProductService;
use Elastic\Elasticsearch\Client;
use Illuminate\Support\Arr;

class ProductController extends Controller
{
    public function __construct(private readonly ProductService $productService)
    {
    }

    public function index(){

//        Elasticsearch::indices()->delete(['index' => 'models']);
        $products = $this->productService->getProductsForView();

        return ProductResource::collection($products);
    }

    public function show(Product $product){

        return new ProductResource($product);
    }

    public function store(ProductCreateRequest $request){

        $data = $request->validated();

        $product = new Product();

        $product->title = $data['title'];
        $product->description = $data['description'] ?? null;
        $product->price = $data['price'] ?: null;
        $product->img_url = $data['img_url'] ?? null;
        $product->quantity = $data['quantity'] ?: null;
        $product->color = $data['color'] ?: null;
        $product->save();

        $product->categories()->attach($data['categories']);

        return response(new ProductResource($product->load('categories')),201);
    }

    public function update(ProductUpdateRequest $request,Product $product){

        $data = $request->validated();

        $product->title = array_key_exists('title',$data) ?  $data['title'] : $product->title;
        $product->description = array_key_exists('description',$data) ? $data['description'] : $product->description;
        $product->price = array_key_exists('price',$data) ? $data['price'] : $product->price;
        $product->img_url = array_key_exists('img_url',$data) ? $data['img_url'] : $product->img_url;
        $product->quantity = array_key_exists('quantity',$data) ? $data['quantity'] : $product->quantity;
        $product->color = array_key_exists('color',$data) ? $data['color'] : $product->color;
        $product->save();

        !array_key_exists('categories',$data) ?: $product->categories()->sync($data['categories']);

        return new ProductResource($product);
    }

    public function delete(Product $product){
        $product->delete();
        return response('success');
    }
}
