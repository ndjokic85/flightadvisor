<?php

namespace Tests\Feature\Api\v1\Users;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserTest extends TestCase
{

    /** @test */
    public function account_can_be_created()
    {
        Role::factory()->create(['name' => Role::USER_ROLE]);
        $response = $this->postJson('api/v1/users', [
            'first_name' => 'Jon',
            'last_name' => 'Donald',
            'username' => 'jon1985',
            'email' => 'jon@test.com',
            'password' => 'password'
        ]);

        $response->assertStatus(201);
    }
}
