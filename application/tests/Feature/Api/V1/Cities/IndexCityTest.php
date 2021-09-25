<?php

namespace Tests\Feature\Api\V1\Users;

use App\Http\Resources\CityResource;
use App\Models\City;
use App\Models\Comment;
use App\Models\Country;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Eloquent\CityRepository;
use App\Repositories\ICityRepository;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class IndexCityTest extends TestCase
{

    private CityRepository $cityRepository;
    private string $url = 'api/v1/cities';

    public function __construct()
    {
        parent::__construct();
        $this->cityRepository = new CityRepository(new City());
    }

    /** @test */
    public function all_cities_with_all_comments_are_listable()
    {
        $country = Country::factory()->create(['name' => 'country1']);
        $role = Role::factory()->user()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        $cities = City::factory()->count(3)->create(['country_id' => $country->id]);
        $cities->each(function ($item, $key) {
            Comment::factory()->count(2)->create(['city_id' => $item->id]);
        });

        $cities = $this->cityRepository->all();
        Sanctum::actingAs($user);
        $this->getJson($this->url)
            ->assertSuccessful()
            ->assertSimilarJson(CityResource::collection($cities)->response()->getData(true));
    }

    /** @test */
    public function city_comments_can_be_limited()
    {
        $country = Country::factory()->create(['name' => 'country2']);
        $role = Role::factory()->user()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        $city = City::factory()->create(['country_id' => $country->id]);
        Comment::factory()->count(5)->create(['city_id' => $city->id]);
        $args['comments_limit'] = 3;
        $cities = $this->cityRepository->all($args);
        Sanctum::actingAs($user);
        $this->getJson($this->url . '?comments_limit=' . $args['comments_limit'])
            ->assertSuccessful()
            ->assertExactJson(CityResource::collection($cities)->response()->getData(true));
    }

    /** @test */
    public function cities_are_searchable()
    {
        $role = Role::factory()->user()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        City::factory()->create(['name' => 'New York']);
        City::factory()->create(['name' => 'London']);
        City::factory()->create(['name' => 'New Delhi']);
        $args['name'] = 'New';
        $cities = $this->cityRepository->all($args);
        Sanctum::actingAs($user);
        $this->getJson($this->url . '?name=' . $args['name'])
            ->assertSuccessful()
            ->assertExactJson(CityResource::collection($cities)->response()->getData(true));
    }

    /** @test */
    public function cities_with_comments_cannot_be_listable_by_anonymous_user()
    {
        $country = Country::factory()->create(['name' => 'country2']);
        $role = Role::factory()->user()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        $city = City::factory()->create(['country_id' => $country->id]);
        Comment::factory()->count(2)->create(['city_id' => $city->id]);
        $this->getJson($this->url)
            ->assertUnauthorized();
    }


    /** @test */
    public function comments_limit_should_be_numeric()
    {
        $country = Country::factory()->create(['name' => 'country2']);
        $role = Role::factory()->user()->create();
        $roleIds = collect([$role->id])->toArray();
        $user = User::factory()->create();
        $user->syncRoles($roleIds);
        $city = City::factory()->create(['country_id' => $country->id]);
        Comment::factory()->count(5)->create(['city_id' => $city->id]);
        Sanctum::actingAs($user);
        $commentsLimit = 'string';
        $response = $this->getJson($this->url . '?comments_limit=' . $commentsLimit)
            ->assertUnprocessable();
        $response->assertJsonValidationErrors(['comments_limit']);
        $this->assertSame(
            'The comments limit must be a number.',
            $response->json('errors.comments_limit.0')
        );
    }
}
