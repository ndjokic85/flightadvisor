<?php

namespace Tests\Feature\Api\v1\Imports;

use App\Models\City;
use App\Models\Role;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AirportImporterTest extends TestCase
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
}
