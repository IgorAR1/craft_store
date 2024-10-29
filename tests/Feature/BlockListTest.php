<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlockListTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_admin_can_add_user_to_blocklist(){

        $user = User::factory()->create();
        $adminToken = $this->createAdminToken();
        $response = $this->putJson('api/v1/blocks/'.$user->id,headers:['Authorization' => $adminToken]);
//        dd($response);
        $this->assertTrue((bool)$user->is_banned);
        $response->assertStatus(204);
    }

    public function createAdminToken(){
        $response = $this->post('api/v1/auth/login',['email' => 'admin@mail.ru','password' => 'password']);
        return $response->json()['token'];
    }

}
