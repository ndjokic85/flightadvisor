<?php

namespace Tests\Feature\Api\V1\Imports;

use App\Models\City;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AirportImporterTest extends TestCase
{

    /** @test */
    public function airport_data_can_be_uploaded_by_admin_successfully()
    {
        $adminRole = Role::factory()->admin()->create();
        $userIds = collect([$adminRole->id])->toArray();
        $admin = User::factory()->create();
        $admin->syncRoles($userIds);
        Sanctum::actingAs($admin);
        $payload = [
            'file' => UploadedFile::fake()->createWithContent(
                'airports.txt',
                file_get_contents(__DIR__ . '/data/airports.txt')
            ),
        ];
        $response = $this->postJson('api/v1/admin/airport-import', $payload);
        $response->assertSuccessful();
    }

    /** @test */
    public function airport_data_can_not_be_uploaded_by_normal_user()
    {
        $userRole = Role::factory()->user()->create();
        $userIds = collect([$userRole->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($userIds);
        Sanctum::actingAs($user);
        $response = $this->postJson('api/v1/admin/airport-import', []);
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
        $response = $this->postJson('api/v1/admin/airport-import', ['file' => '']);
        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['file']);
        $this->assertSame(
            'The file field is required.',
            $response->json('errors.file.0')
        );
    }
}
