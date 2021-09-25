<?php

namespace Tests\Feature\Api\V1\Users;

use App\Models\City;
use App\Models\Comment;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UpdateCityCommentTest extends TestCase
{


    /** @test */
    public function city_comment_can_be_updated_by_auth_user()
    {
        $role = Role::factory()->user()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        $city = City::factory()->create();
        $comment = Comment::factory()->create([
            'comment' => 'Comment current',
            'user_id' => $user->id,
            'city_id' => $city->id
        ]);
        $this->assertEquals('Comment current', $comment->comment);
        Sanctum::actingAs($user);
        $response = $this->patchJson('api/v1/cities/' . $city->id . '/comments/' . $comment->id, [
            'comment' => 'New comment 1'
        ]);
        $this->assertEquals('New comment 1', $comment->refresh()->comment);
        $response->assertSuccessful();
    }


    /** @test */
    public function city_comment_can_not_be_updated_by_wrong_owner()
    {
        $role = Role::factory()->user()->create();
        $roleIds = collect([$role->id])->toArray();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user1->syncRoles($roleIds);
        $user2->syncRoles($roleIds);
        $city = City::factory()->create();
        $comment = Comment::factory()->create([
            'comment' => 'Comment current',
            'user_id' => $user1->id,
            'city_id' => $city->id
        ]);
        $this->assertEquals('Comment current', $comment->comment);
        Sanctum::actingAs($user2);
        $response = $this->patchJson('api/v1/cities/' . $city->id . '/comments/' . $comment->id, [
            'comment' => 'New comment 1'
        ]);
        $response->assertUnauthorized();
    }

    /** @test */
    public function city_comment_can_not_be_updated_by_anonymous_user()
    {
        $role = Role::factory()->user()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        $city = City::factory()->create();
        $comment = Comment::factory()->create([
            'comment' => 'Comment current',
            'city_id' => $city->id,
            'user_id' => $user->id,
        ]);
        $response = $this->patchJson('api/v1/cities/' . $city->id . '/comments/' . $comment->id, [
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
        $comment = Comment::factory()->create([
            'comment' => 'Comment current',
            'user_id' => $user->id,
            'city_id' => $city->id
        ]);
        Sanctum::actingAs($user);
        $response = $this->patchJson('api/v1/cities/' . $city->id . '/comments/' . $comment->id, [
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
