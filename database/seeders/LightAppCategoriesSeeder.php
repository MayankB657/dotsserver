<?php

namespace Database\Seeders;

use App\Models\LightAppCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LightAppCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        Lightappcategory::create([
            'id' => 1,
            'name' => 'Tool',
            'sort_order' => 0,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        Lightappcategory::create([
            'id' => 2,
            'name' => 'Game',
            'sort_order' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        LightAppCategory::create([
            'id' => 3,
            'name' => 'Music',
            'sort_order' => 1,
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
