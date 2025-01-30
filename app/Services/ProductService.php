<?php

namespace App\Services;

use App\Enums\SqlOperators;
use App\Factories\FilterFactory;
use App\Http\Requests\QueryRequest;
use App\Models\File;
use App\Models\Product;
use App\Services\Files\ImageAdder;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function __construct(readonly QueryRequest $queryRequest,
                                readonly FilterFactory $filterFactory,
                                readonly ImageAdder $imageAdder)
    {
    }

    public function createProduct(array $data): Product
    {
        ///Кароче передаем в DTO, массив это полная лажа
        return DB::transaction(function () use ($data): Product  {

            $product = new Product();

            $product->title = $data['title'];
            $product->description = $data['description'] ?? null;
            $product->price = $data['price'] ?: null;
            $product->quantity = $data['quantity'] ?: null;
            $product->color = $data['color'] ?: null;

            $product->save();

            $product->categories()->attach($data['categories']);

            $imagesIds = $data['images'] ?? [];
            $images = File::query()->findMany($imagesIds);
            $this->imageAdder->setModel($product);
            $images->each(function (File $file) use ($product) {
                $this->imageAdder->addImage($file);
            });

            return $product;
        });
    }

    public function updateProduct(Product $product, array $data): Product
    {
        $product->title = array_key_exists('title',$data) ?  $data['title'] : $product->title;
        $product->description = array_key_exists('description',$data) ? $data['description'] : $product->description;
        $product->price = array_key_exists('price',$data) ? $data['price'] : $product->price;
//        $product->img_url = array_key_exists('img_url',$data) ? $data['img_url'] : $product->img_url;
        $product->quantity = array_key_exists('quantity',$data) ? $data['quantity'] : $product->quantity;
        $product->color = array_key_exists('color',$data) ? $data['color'] : $product->color;

        $product->save();

        !array_key_exists('categories',$data) ?: $product->categories()->sync($data['categories']);

        return $product;
    }

    public function getProductsForView()
    {
        $filterFactory = $this->filterFactory;

        return Product::search($this->queryRequest->getSearchQuery())
            ->filter([//Мб через свитчи в фабрике//Фабрику в фасад еще можно
                'price' => $filterFactory->createExactFilter(),///типа 'price' => 'exact'
                'price_min' => $filterFactory->createRangeFilter(SqlOperators::GREATER_THAN),
                'price_max' => $filterFactory->createRangeFilter(SqlOperators::LESS_THAN),
            ])
            ->sort([
                'description',
                'categories',
                'title'
            ])
            ->paginate(10);
    }


}
