<?php

namespace Tests\Feature\Api\V1\Users;

use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateCityTest extends TestCase
{

    private string $url = 'api/v1/admin/cities';

    /** @test */
    public function city_can_be_created_only_by_admin()
    {
        $adminRole = Role::factory()->admin()->create();
        $adminRoleIds = collect([$adminRole->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($adminRoleIds);
        Sanctum::actingAs($user);
        $response = $this->postJson($this->url, [
            'name' => 'New York',
            'description' => 'This is a New York',
            'country_id' => Country::factory()->create()->id
        ]);
        $response->assertCreated();
    }

    /** @test */
    public function city_cannot_be_created_by_regular_user()
    {
        $role = Role::factory()->user()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        Sanctum::actingAs($user);
        $response = $this->postJson($this->url, [
            'name' => 'London',
            'description' => 'This is a London',
            'country_id' => Country::factory()->create()->id
        ]);
        $response->assertUnauthorized();
    }

    /** @test */
    public function name_is_required()
    {
        $role= Role::factory()->admin()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        Sanctum::actingAs($user);
        $response = $this->postJson($this->url, [
            'name' => ''
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['name']);
        $this->assertSame(
            'The name field is required.',
            $response->json('errors.name.0')
        );
    }

    /** @test */
    public function description_is_required()
    {
        $role = Role::factory()->admin()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        Sanctum::actingAs($user);
        $response = $this->postJson($this->url, [
            'description' => ''
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['description']);
        $this->assertSame(
            'The description field is required.',
            $response->json('errors.description.0')
        );
    }

    /** @test */
    public function country_id_is_required()
    {
        $role = Role::factory()->admin()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        Sanctum::actingAs($user);
        $response = $this->postJson($this->url, [
            'country_id' => ''
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['country_id']);
        $this->assertSame(
            'The country id field is required.',
            $response->json('errors.country_id.0')
        );
    }

    /** @test */
    public function country_id_must_exists_in_countries_table()
    {
        $role = Role::factory()->admin()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        Sanctum::actingAs($user);
        $response = $this->postJson($this->url, [
            'country_id' => 7
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['country_id']);
        $this->assertSame(
            'The selected country id is invalid.',
            $response->json('errors.country_id.0')
        );
    }

    /** @test */
    public function country_id_must_be_numeric()
    {
        $role = Role::factory()->admin()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        Sanctum::actingAs($user);
        $response = $this->postJson($this->url, [
            'country_id' => 'd'
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['country_id']);
        $this->assertSame(
            'The country id must be a number.',
            $response->json('errors.country_id.0')
        );
    }
}
