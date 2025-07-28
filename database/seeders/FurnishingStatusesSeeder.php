<?php

namespace Database\Seeders;

use App\Models\FurnishingStatus;
use Illuminate\Database\Seeder;

class FurnishingStatusesSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = ['Furnished', 'Semi-Furnished', 'Unfurnished'];
        foreach ($statuses as $status) {
            FurnishingStatus::firstOrCreate(['name' => $status]);
        }
    }
}

