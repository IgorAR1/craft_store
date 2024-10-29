<?php

namespace Tests\Feature;

use App\Models\Product;
use GuzzleHttp\Promise\Create;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProductsTest extends TestCase
{
    use WithFaker;
    // use RefreshDatabase;

    public function test_user_can_create_product():void {

        $data = [
            "title" => "Часики",
            "description" => "gerger",
            "price" => 434,
            "img_url" => "https://www.google.com/search?sca_esv=f3ed14a816e3a85c&sca_upv=1&q=%D0%BA%D0%B0%D1%80%D1%82%D0%B8%D0%BD%D0%BA%D0%B8&udm=2&fbs=AEQNm0Cjmfui-wh8X_MyYW04R9TpEz659VicRvdQoqLb32FEYtz9ghAES1yRtdnSWbgjSrKC1IfMtFTKUsdltxh9toINrzStdIlCBceZl_foKvRSW9Tkt-sNYnmPo793dhPX8r63clcJh6cSvGw7O_CduM5FcId0Q-vu-R_OLitntAdM6EgP1N8MU8DF3jyLDjIuc8uxZ5qZoI6foDxnpVRQfebfOl_JUKxvpVRQWipraxzTga7rPjU&sa=X&ved=2ahUKEwj6uunU1eiIAxWNgSoKHZSxFYoQtKgLegQIGBAB&biw=1920&bih=992&dpr=1#vhid=9wJuQPxSWfQ95M&vssid=mosaic",
            "quantity" => 34,
            "color" => "black",
            "categories"=> [1,2],
        ];

        $response = $this->post('api/v1/products',
    $data);

        $response->assertStatus(201);
    }

    public function test_user_can_update_product():void {

        $data = [
            "title" => "Часики",
            "description" => "gerger",
            "price" => 434,
            "img_url" => "https://www.google.com/search?sca_esv=f3ed14a816e3a85c&sca_upv=1&q=%D0%BA%D0%B0%D1%80%D1%82%D0%B8%D0%BD%D0%BA%D0%B8&udm=2&fbs=AEQNm0Cjmfui-wh8X_MyYW04R9TpEz659VicRvdQoqLb32FEYtz9ghAES1yRtdnSWbgjSrKC1IfMtFTKUsdltxh9toINrzStdIlCBceZl_foKvRSW9Tkt-sNYnmPo793dhPX8r63clcJh6cSvGw7O_CduM5FcId0Q-vu-R_OLitntAdM6EgP1N8MU8DF3jyLDjIuc8uxZ5qZoI6foDxnpVRQfebfOl_JUKxvpVRQWipraxzTga7rPjU&sa=X&ved=2ahUKEwj6uunU1eiIAxWNgSoKHZSxFYoQtKgLegQIGBAB&biw=1920&bih=992&dpr=1#vhid=9wJuQPxSWfQ95M&vssid=mosaic",
            "quantity" => 34,
            "color" => "black",
            "categories"=> [1,2],
        ];

        $product = Product::inRandomOrder()->first();

        $response = $this->patchJson('api/v1/products/'.$product->id ,$data);

        $response->assertStatus(200);
    }

}
