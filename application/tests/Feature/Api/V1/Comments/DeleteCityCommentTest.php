<?php

namespace Tests\Feature\Api\V1\Users;

use App\Models\City;
use App\Models\Comment;
use App\Models\Role;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeleteCityCommentTest extends TestCase
{

    /** @test */
    public function city_comment_can_be_deleted_by_auth_user()
    {
        $role = Role::factory()->user()->create();
        $user = User::factory()->create();
        $roleIds = collect([$role->id])->toArray();
        $user->syncRoles($roleIds);
        $city = City::factory()->create();
        $comment1 = Comment::factory()->create([
            'comment' => 'Comment 1', 
            'user_id' => $user->id,
            'city_id' => $city->id
        ]);
        $comment2 = Comment::factory()->create([
            'comment' => 'Comment 2', 
            'user_id' => $user->id,
            'city_id' => $city->id
        ]);
        $this->assertEquals('Comment 1', $comment1->comment);
        $this->assertEquals('Comment 2', $comment2->comment);
        Sanctum::actingAs($user);
        $response = $this->deleteJson('api/v1/cities/' . $city->id . '/comments/' . $comment1->id);
        $response->assertNoContent();
        $this->assertEquals(1, Comment::all()->count());
        $response = $this->deleteJson('api/v1/cities/' . $city->id . '/comments/' . $comment2->id);
        $this->assertEquals(0, Comment::all()->count());
    }


    /** @test */
    public function city_comment_can_not_be_deleted_by_wrong_owner()
    {
        $role = Role::factory()->user()->create();
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $roleIds = collect([$role->id])->toArray();
        $user1->syncRoles($roleIds);
        $user2->syncRoles($roleIds);
        $city = City::factory()->create();
        $comment = Comment::factory()->create([
            'comment' => 'Comment 1',
            'user_id' => $user1->id,
            'city_id' => $city->id
        ]);
        Sanctum::actingAs($user2);
        $response = $this->deleteJson('api/v1/cities/' . $city->id . '/comments/' . $comment->id);
        $response->assertUnauthorized();
    }

    /** @test */
    public function any_city_comment_can_be_deleted_by_admin_user()
    {
        $adminRole = Role::factory()->admin()->create();
        $userRole =  Role::factory()->user()->create();
        $adminUser = User::factory()->create();
        $normalUser = User::factory()->create();
        $adminUser->syncRoles(collect([$adminRole->id])->toArray());
        $normalUser->syncRoles(collect([$userRole->id])->toArray());
        $city = City::factory()->create();
        $comment = Comment::factory()->create([
            'comment' => 'Comment 1',
            'user_id' => $normalUser->id,
            'city_id' => $city->id
        ]);
        Sanctum::actingAs($adminUser);
        $response = $this->deleteJson('api/v1/cities/' . $city->id . '/comments/' . $comment->id);
        $response->assertNoContent();
    }
}
