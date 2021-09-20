<?php

namespace Tests\Feature\Api\v1\Users;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateUserTest extends TestCase
{

    /** @test */
    public function account_can_be_created()
    {
        $userRole = Role::factory()->create(['name' => Role::USER_ROLE]);
        $response = $this->postJson('api/v1/users', [
            'first_name' => 'Jon',
            'last_name' => 'Donald',
            'username' => 'jon1985',
            'email' => 'jon@test.com',
            'password' => 'password'
        ]);

        $response->assertStatus(201);
        $user = User::find($response->json()['data']['id']);
        $response->assertExactJson(UserResource::make($user)->response()->getData(true));
        $this->assertEquals($user->username, 'jon1985');
        $this->assertEquals($user->first_name, 'Jon');
        $this->assertTrue($user->hasRole($userRole->name));
    }
}
