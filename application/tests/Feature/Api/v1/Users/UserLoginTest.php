<?php

namespace Tests\Feature\Api\v1\Users;

use App\Models\Role;
use App\Models\User;
use Tests\TestCase;

class UserLoginTest extends TestCase
{

    private string $url = 'api/v1/users/login';

    /** @test */
    public function user_can_be_authenticated()
    {
        $roleId = Role::factory()->user()->create()->pluck('id')->toArray();
        $user = User::factory()->create(['username' => 'test']);
        $user->syncRoles($roleId);
        $response = $this->postJson($this->url, [
            'username' => 'test',
            'password' => 'password'
        ]);
        $response->assertOk();
    }

    /** @test */
    public function user_with_wrong_credentials_can_not_be_authenticated()
    {
        $roleId = Role::factory()->user()->create()->pluck('id')->toArray();
        $user = User::factory()->create(['username' => 'test']);
        $user->syncRoles($roleId);
        $response = $this->postJson($this->url, [
            'username' => 'test1',
            'password' => 'password'
        ]);
        $response->assertUnauthorized();
    }


    /** @test */
    public function password_must_be_at_least_6_characters()
    {
        $response = $this->postJson($this->url, [
            'password' => 'test'
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
        $this->assertSame(
            'The password must be at least 6 characters.',
            $response->json('errors.password.0')
        );
    }

    /** @test */
    public function username_is_required()
    {
        $response = $this->postJson($this->url, [
            'username' => ''
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['username']);
        $this->assertSame(
            'The username field is required.',
            $response->json('errors.username.0')
        );
    }

    /** @test */
    public function password_is_required()
    {
        $response = $this->postJson($this->url, [
            'password' => ''
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
        $this->assertSame(
            'The password field is required.',
            $response->json('errors.password.0')
        );
    }
}
