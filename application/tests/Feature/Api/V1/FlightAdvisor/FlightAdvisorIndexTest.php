<?php

namespace Tests\Feature\Api\V1\FlightAdvisor;

use App\Models\Airport;
use App\Models\City;
use App\Models\Role;
use App\Models\Route;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FlightAdvisorIndexTest extends TestCase
{

    /** @test */
    public function cheapest_flight_with_all_routes_are_listable_for_user()
    {
        $userRole = Role::factory()->user()->create();
        $userIds = collect([$userRole->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($userIds);
        Sanctum::actingAs($user);
        $cityBelgrade = City::factory()->create(['name' => 'Belgrade']);
        $cityLondon = City::factory()->create(['name' => 'London']);
        $cityNewYork = City::factory()->create(['name' => 'New York']);
        $cityBerlin = City::factory()->create(['name' => 'Berlin']);

        $airPortBelgrade = Airport::factory()->create([
            'city_id' => $cityBelgrade->id,
            'name' => 'Aerodrom Belgrade'
        ]);
        $airPortLondon = Airport::factory()->create([
            'city_id' => $cityLondon->id,
            'name' => 'Aerodrom London'
        ]);
        $airPortNewYork = Airport::factory()->create([
            'city_id' => $cityNewYork->id,
            'name' => 'Aerodrom New York'
        ]);
        $airPortBerlin = Airport::factory()->create([
            'city_id' => $cityBerlin->id,
            'name' => 'Aerodrom Berlin'
        ]);

        Route::factory()->create([
            'source_airport_id' => $airPortBelgrade->id,
            'destination_airport_id' => $airPortLondon->id,
            'price' => 100
        ]);
        Route::factory()->create([
            'source_airport_id' => $airPortLondon->id,
            'destination_airport_id' => $airPortBelgrade->id,
            'price' => 150
        ]);

        Route::factory()->create([
            'source_airport_id' => $airPortLondon->id,
            'destination_airport_id' => $airPortNewYork->id,
            'price' => 550.50
        ]);

        Route::factory()->create([
            'source_airport_id' => $airPortNewYork->id,
            'destination_airport_id' => $airPortLondon->id,
            'price' => 600
        ]);
        Route::factory()->create([
            'source_airport_id' => $airPortNewYork->id,
            'destination_airport_id' => $airPortBelgrade->id,
            'price' => 1000
        ]);
        $response = $this->getJson('api/v1/routes?source=' . $airPortBelgrade->id . '&destination=' . $airPortNewYork->id)
            ->assertSuccessful();

        $expectedResponse1 = [
            'routes' => [
                [
                    'price' => 100,
                    'source' => 'Belgrade',
                    'destination' => 'London'
                ],
                [
                    'price' => 550.5,
                    'source' => 'London',
                    'destination' => 'New York'
                ]
            ],
            'total_price' => 650.5

        ];
        $this->assertEquals($expectedResponse1, $response['data']);

        $response = $this->getJson('api/v1/routes?source=' . $airPortBelgrade->id . '&destination=' . $airPortLondon->id)
            ->assertSuccessful();

        $expectedResponse2 = [
            'routes' => [
                [
                    'price' => 100,
                    'source' => 'Belgrade',
                    'destination' => 'London'
                ],
            ],
            'total_price' => 100

        ];
        $this->assertEquals($expectedResponse2, $response['data']);


        $response = $this->getJson('api/v1/routes?source=' . $airPortNewYork->id . '&destination=' . $airPortBelgrade->id)
            ->assertSuccessful();

        $expectedResponse3 = [
            'routes' => [
                [
                    'price' => 600,
                    'source' => 'New York',
                    'destination' => 'London'
                ],

                [
                    'price' => 150,
                    'source' => 'London',
                    'destination' => 'Belgrade'
                ],
            ],
            'total_price' => 750

        ];
        $this->assertEquals($expectedResponse3, $response['data']);
    }

    /** @test */
    public function cheapest_flight_cannot_be_found_for_non_existing_route()
    {
        $userRole = Role::factory()->user()->create();
        $userIds = collect([$userRole->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($userIds);
        Sanctum::actingAs($user);
        $cityBelgrade = City::factory()->create(['name' => 'Belgrade']);
        $cityLondon = City::factory()->create(['name' => 'London']);
        $cityNewYork = City::factory()->create(['name' => 'New York']);
        $cityBerlin = City::factory()->create(['name' => 'Berlin']);

        $airPortBelgrade = Airport::factory()->create([
            'city_id' => $cityBelgrade->id,
            'name' => 'Aerodrom Belgrade'
        ]);
        $airPortLondon = Airport::factory()->create([
            'city_id' => $cityLondon->id,
            'name' => 'Aerodrom London'
        ]);
        $airPortNewYork = Airport::factory()->create([
            'city_id' => $cityNewYork->id,
            'name' => 'Aerodrom New York'
        ]);
        $airPortBerlin = Airport::factory()->create([
            'city_id' => $cityBerlin->id,
            'name' => 'Aerodrom Berlin'
        ]);

        Route::factory()->create([
            'source_airport_id' => $airPortBelgrade->id,
            'destination_airport_id' => $airPortLondon->id,
            'price' => 100
        ]);
        Route::factory()->create([
            'source_airport_id' => $airPortLondon->id,
            'destination_airport_id' => $airPortBelgrade->id,
            'price' => 150
        ]);

        Route::factory()->create([
            'source_airport_id' => $airPortLondon->id,
            'destination_airport_id' => $airPortNewYork->id,
            'price' => 550.50
        ]);

        Route::factory()->create([
            'source_airport_id' => $airPortNewYork->id,
            'destination_airport_id' => $airPortLondon->id,
            'price' => 600
        ]);
        $response = $this->getJson('api/v1/routes?source=' . $airPortBelgrade->id . '&destination=' . $airPortBerlin->id)
            ->assertSuccessful();
        $expectedResponse = [
            'routes' => [],
            'total_price' => 0

        ];
        $this->assertEquals($expectedResponse, $response['data']);
    }


    /** @test */
    public function flight_advisor_can_not_be_used_by_non_auth_user()
    {
        $userRole = Role::factory()->user()->create();
        $userIds = collect([$userRole->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($userIds);
        $response = $this->getJson('api/v1/routes')
            ->assertUnauthorized();
    }

    /** @test */
    public function airport_source_field_is_required()
    {
        $userRole = Role::factory()->user()->create();
        $userIds = collect([$userRole->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($userIds);
        Sanctum::actingAs($user);
        $response = $this->getJson('api/v1/routes')->assertUnprocessable();
        $response->assertJsonValidationErrors(['source']);
        $this->assertSame(
            'The source field is required.',
            $response->json('errors.source.0')
        );
    }

    /** @test */
    public function airport_destination_field_is_required()
    {
        $userRole = Role::factory()->user()->create();
        $userIds = collect([$userRole->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($userIds);
        Sanctum::actingAs($user);
        $response = $this->getJson('api/v1/routes')->assertUnprocessable();
        $response->assertJsonValidationErrors(['destination']);
        $this->assertSame(
            'The destination field is required.',
            $response->json('errors.destination.0')
        );
    }

    /** @test */
    public function airport_source_field_must_be_number()
    {
        $userRole = Role::factory()->user()->create();
        $userIds = collect([$userRole->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($userIds);
        Sanctum::actingAs($user);
        $response = $this->getJson('api/v1/routes?source=')->assertUnprocessable();
        $response->assertJsonValidationErrors(['source']);
        $this->assertSame(
            'The source must be a number.',
            $response->json('errors.source.0')
        );
    }

    /** @test */
    public function airport_destination_field_must_be_number()
    {
        $userRole = Role::factory()->user()->create();
        $userIds = collect([$userRole->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($userIds);
        Sanctum::actingAs($user);
        $response = $this->getJson('api/v1/routes?destination=')->assertUnprocessable();
        $response->assertJsonValidationErrors(['destination']);
        $this->assertSame(
            'The destination must be a number.',
            $response->json('errors.destination.0')
        );
    }

    /** @test */
    public function destination_must_be_a_valid_airport_id()
    {
        $userRole = Role::factory()->user()->create();
        $userIds = collect([$userRole->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($userIds);
        Sanctum::actingAs($user);
        $response = $this->getJson('api/v1/routes?destination=345')->assertUnprocessable();
        $response->assertJsonValidationErrors(['destination']);
        $this->assertSame(
            'The selected destination is invalid.',
            $response->json('errors.destination.0')
        );
    }

    /** @test */
    public function source_must_be_a_valid_airport_id()
    {
        $userRole = Role::factory()->user()->create();
        $userIds = collect([$userRole->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($userIds);
        Sanctum::actingAs($user);
        $response = $this->getJson('api/v1/routes?source=3454')->assertUnprocessable();
        $response->assertJsonValidationErrors(['source']);
        $this->assertSame(
            'The selected source is invalid.',
            $response->json('errors.source.0')
        );
    }
}
