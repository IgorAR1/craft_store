<?php

namespace Tests\Feature;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoriesTest extends TestCase
{

    const JSON_STRUCTURE = [
        'title'
    ];


    public function test_update_category(){

        $category = Category::factory()->create();
        $data = fake()->unique()->name();

        $response = $this->put('api/v1/categories/'.$category->id,['title' => $data]);

        $response->assertJson(['title' => $data])
            ->assertOk();
    }

//    public function test_delete_category(){
//
//
//    }
}
