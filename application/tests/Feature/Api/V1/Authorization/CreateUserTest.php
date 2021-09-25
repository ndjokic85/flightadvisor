<?php

namespace Tests\Feature\Api\V1\Authorization;

use App\Http\Resources\UserResource;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class CreateUserTest extends TestCase
{

    private string $url = 'api/v1/users';

    /** @test */
    public function account_can_be_created()
    {
        $userRole = Role::factory()->create(['name' => Role::USER_ROLE]);
        $response = $this->postJson($this->url, [
            'first_name' => 'Jon',
            'last_name' => 'Donald',
            'username' => 'jon1985',
            'email' => 'jon@test.com',
            'password' => 'password'
        ]);

        $response->assertCreated();
        $user = User::find($response->json()['data']['id']);
        $response->assertExactJson(UserResource::make($user)->response()->getData(true));
        $this->assertEquals($user->username, 'jon1985');
        $this->assertEquals($user->first_name, 'Jon');
        $this->assertTrue($user->hasRole($userRole->name));
    }

    /** @test */
    public function username_is_required()
    {
        $response = $this->postJson($this->url, [
            'username' => ''
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['username']);
        $this->assertSame(
            'The username field is required.',
            $response->json('errors.username.0')
        );
    }

    /** @test */
    public function first_name_is_required()
    {
        $response = $this->postJson($this->url, [
            'first_name' => ''
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['first_name']);
        $this->assertSame(
            'The first name field is required.',
            $response->json('errors.first_name.0')
        );
    }

    /** @test */
    public function last_name_is_required()
    {
        $response = $this->postJson($this->url, [
            'last_name' => ''
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['last_name']);
        $this->assertSame(
            'The last name field is required.',
            $response->json('errors.last_name.0')
        );
    }

    /** @test */
    public function password_is_required()
    {
        $response = $this->postJson($this->url, [
            'password' => ''
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['password']);
        $this->assertSame(
            'The password field is required.',
            $response->json('errors.password.0')
        );
    }

    /** @test */
    public function password_must_be_at_least_6_characters()
    {
        $response = $this->postJson($this->url, [
            'password' => 'test'
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['password']);
        $this->assertSame(
            'The password must be at least 6 characters.',
            $response->json('errors.password.0')
        );
    }

    /** @test */
    public function last_name_must_be_less_than_256_characters()
    {
        $response = $this->postJson($this->url, [
            'last_name' => Str::random(257),
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['last_name']);
        $this->assertSame(
            'The last name must not be greater than 255 characters.',
            $response->json('errors.last_name.0')
        );
    }

    /** @test */
    public function first_name_must_be_less_than_256_characters()
    {
        $response = $this->postJson($this->url, [
            'first_name' => Str::random(257),
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['first_name']);
        $this->assertSame(
            'The first name must not be greater than 255 characters.',
            $response->json('errors.first_name.0')
        );
    }
}
