<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void 
     */
    public function run()
    {
        $countries = [
            'United Kingdom',
            'USA',
            'Belgium',
            'France',
            'Germany',
            'Papua New Guinea',
            'Canada',
            'Philippines',
        ];
        foreach ($countries as $countryName) {
            Country::create(['name' => $countryName]);
        }
    }
}
