<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WallpaperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $wallpapers = [
            ['image' => 'wallpaper1.jpg', 'type' => 0, 'status' => 1, 'created_by' => 1, 'default' => 1],
            ['image' => 'wallpaper2.jpg', 'type' => 0, 'status' => 1, 'created_by' => 1, 'default' => 1],
            ['image' => 'wallpaper3.jpg', 'type' => 0, 'status' => 1, 'created_by' => 1, 'default' => 1],
            ['image' => 'wallpaper4.jpg', 'type' => 0, 'status' => 1, 'created_by' => 1, 'default' => 1],
            ['image' => 'wallpaper5.jpg', 'type' => 0, 'status' => 1, 'created_by' => 1, 'default' => 1],
            ['image' => 'wallpaper6.jpg', 'type' => 0, 'status' => 1, 'created_by' => 1, 'default' => 1],
            // ['image' => 'wallpaper7.jpg', 'type' => 0, 'status' => 1, 'created_by' => 1, 'default' => 1],
            // ['image' => 'wallpaper8.jpg', 'type' => 0, 'status' => 1, 'created_by' => 1, 'default' => 1],
            // Login wallpapers
            ['image' => 'wallpaper1.jpg', 'type' => 1, 'status' => 1, 'created_by' => 1, 'default' => 1],
            ['image' => 'wallpaper2.jpg', 'type' => 1, 'status' => 1, 'created_by' => 1, 'default' => 1],
            ['image' => 'wallpaper3.jpg', 'type' => 1, 'status' => 1, 'created_by' => 1, 'default' => 1],
            ['image' => 'wallpaper4.jpg', 'type' => 1, 'status' => 1, 'created_by' => 1, 'default' => 1],
            ['image' => 'wallpaper5.jpg', 'type' => 1, 'status' => 1, 'created_by' => 1, 'default' => 1],
            ['image' => 'wallpaper6.jpg', 'type' => 1, 'status' => 1, 'created_by' => 1, 'default' => 1],
            // ['image' => 'wallpaper7.jpg', 'type' => 1, 'status' => 1, 'created_by' => 1, 'default' => 1],
            // ['image' => 'wallpaper8.jpg', 'type' => 1, 'status' => 1, 'created_by' => 1, 'default' => 1],
        ];

        // Insert the wallpapers into the database
        DB::table('wallpapers')->insert($wallpapers);
    }
}
