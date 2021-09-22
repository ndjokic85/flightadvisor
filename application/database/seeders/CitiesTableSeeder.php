<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use Illuminate\Database\Seeder;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void 
     */
    public function run()
    {
        $countries = [
            'Papua New Guinea' => ['Goroka', 'Madang', 'Mount Hagen'],
            'Canada' => ['Tofino', 'Bagotville', 'Baker Lake'],
            'Germany' => ['Dessau', 'Barth', 'Kyritz'],
            'Philippines' => ['Ozamis']
        ];
        foreach ($countries as $country => $cities) {
            $country = Country::where('name', $country)->first();
            if ($country) {
                foreach ($cities as $cityName) {
                    City::create(['name' => $cityName, 'description' => 'desc..', 'country_id' => $country->id]);
                }
            }
        }
    }
}
