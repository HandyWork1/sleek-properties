<?php

namespace Database\Seeders;

use App\Models\PropertyType;
use Illuminate\Database\Seeder;

class PropertyTypesSeeder extends Seeder
{
    public function run(): void
    {
        $types = ['Apartment', 'House', 'Villa', 'Commercial', 'Land', 'Office'];
        foreach ($types as $type) {
            PropertyType::firstOrCreate(['name' => $type]);
        }
    }
}
