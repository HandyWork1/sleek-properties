<?php

namespace Database\Seeders;

use App\Models\PropertyCondition;
use Illuminate\Database\Seeder;

class PropertyConditionsSeeder extends Seeder
{
    public function run(): void
    {
        $conditions = ['New', 'Good', 'Needs Renovation', 'Under Construction'];
        foreach ($conditions as $condition) {
            PropertyCondition::firstOrCreate(['name' => $condition]);
        }
    }
}

