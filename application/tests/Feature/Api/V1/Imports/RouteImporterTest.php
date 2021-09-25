<?php

namespace Tests\Feature\Api\V1\Imports;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class RouteImporterTest extends TestCase
{

    /** @test */
    public function route_data_can_be_uploaded_by_admin_successfully()
    {
        $adminRole = Role::factory()->admin()->create();
        $userIds = collect([$adminRole->id])->toArray();
        $admin = User::factory()->create();
        $admin->syncRoles($userIds);
        Sanctum::actingAs($admin);
        $payload = [
            'file' => UploadedFile::fake()->createWithContent(
                'routes.txt',
                file_get_contents(__DIR__ . '/data/routes.txt')
            ),
        ];
        $response = $this->postJson('api/v1/admin/route-import', $payload);
        $response->assertSuccessful();
    }

    /** @test */
    public function route_data_can_not_be_uploaded_by_normal_user()
    {
        $userRole = Role::factory()->user()->create();
        $userIds = collect([$userRole->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($userIds);
        Sanctum::actingAs($user);
        $response = $this->postJson('api/v1/admin/route-import', []);
        $response->assertUnauthorized();
    }

    /** @test */
    public function file_is_required()
    {
        $adminRole = Role::factory()->admin()->create();
        $userIds = collect([$adminRole->id])->toArray();
        $admin = User::factory()->create();
        $admin->syncRoles($userIds);
        Sanctum::actingAs($admin);
        $response = $this->postJson('api/v1/admin/route-import', ['file' => '']);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['file']);
        $this->assertSame(
            'The file field is required.',
            $response->json('errors.file.0')
        );
    }
}
