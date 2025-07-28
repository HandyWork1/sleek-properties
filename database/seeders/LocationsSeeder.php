<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\Location;

class LocationsSeeder extends Seeder
{
    public function run(): void
    {
        $locations = [
            ['name' => 'Nairobi',         'country' => 'Kenya'],
            ['name' => 'Mombasa',         'country' => 'Kenya'],
            ['name' => 'Kampala',         'country' => 'Uganda'],
            ['name' => 'Lagos',           'country' => 'Nigeria'],
            ['name' => 'Cape Town',       'country' => 'South Africa'],
            ['name' => 'Johannesburg',    'country' => 'South Africa'],
            ['name' => 'Accra',           'country' => 'Ghana'],
            ['name' => 'Addis Ababa',     'country' => 'Ethiopia'],
            ['name' => 'Dar es Salaam',   'country' => 'Tanzania'],
            ['name' => 'Cairo',           'country' => 'Egypt'],
        ];

        foreach ($locations as $location) {
            $country = Country::where('name', $location['country'])->first();

            if ($country) {
                Location::create([
                    'name' => $location['name'],
                    'country_id' => $country->id,
                ]);
            }
        }
    }
}
