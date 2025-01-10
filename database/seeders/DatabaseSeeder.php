<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            GroupsSeeder::class,
            RolesSeeder::class,
            AppsSeeder::class,
            LightAppCategoriesSeeder::class,
            LightAppsSeeder::class,
            ContextTypesTableSeeder::class,
            ContextOptionsTableSeeder::class,
            UsersSeeder::class,
            QuotesSeeder::class,
            WallpaperSeeder::class
        ]);
    }
}
