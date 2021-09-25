<?php

namespace Tests\Feature\Api\V1\Users;

use App\Models\City;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class CreateCityCommentTest extends TestCase
{

    /** @test */
    public function city_comment_can_be_created_by_auth_user()
    {
        $role = Role::factory()->user()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        $city = City::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->postJson('api/v1/cities/' . $city->id . '/comments', [
            'comment' => 'New comment 1'
        ]);
        $response->assertCreated();
    }

    /** @test */
    public function city_comment_can_not_be_created_by_anonymous_user()
    {
        $role = Role::factory()->user()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        $city = City::factory()->create();
        $response = $this->postJson('api/v1/cities/' . $city->id . '/comments', [
            'comment' => 'New comment 1'
        ]);
        $response->assertUnauthorized();
    }

    /** @test */
    public function comment_field_is_required()
    {
        $role = Role::factory()->user()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        $city = City::factory()->create();
        Sanctum::actingAs($user);
        $response = $this->postJson('api/v1/cities/' . $city->id . '/comments', [
            'comment' => ''
        ]);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['comment']);
        $this->assertSame(
            'The comment field is required.',
            $response->json('errors.comment.0')
        );
    }
}
