<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    public function run(): void
    {
        $countries = ['Kenya', 'Uganda', 'Tanzania', 'Rwanda', 'Nigeria', 'South Africa'];
        foreach ($countries as $country) {
            Country::firstOrCreate(['name' => $country]);
        }
    }
}

