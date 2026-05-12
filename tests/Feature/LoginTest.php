<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_login_persists_session()
    {
        $response = $this->post('/login', [
            'username' => 'admin@gmail.com',
            'password' => '123',
        ]);

        $response->assertRedirect('/admin/products');

        $response2 = $this->get('/admin/products');
        $response2->assertStatus(200);
    }
}
