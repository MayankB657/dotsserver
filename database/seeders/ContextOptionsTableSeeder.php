<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ContextOptionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('context_options')->insert([
            ['id' => 1, 'contexttype' => 4, 'name' => 'Word', 'icon' => NULL, 'image' => 'docx', 'function' => 'docx', 'shortcut' => NULL, 'sort_order' => 1, 'status' => 1],
            ['id' => 2, 'contexttype' => 4, 'name' => 'Excel', 'icon' => NULL, 'image' => 'xlsx', 'function' => 'xlsx', 'shortcut' => NULL, 'sort_order' => 2, 'status' => 1],
            ['id' => 3, 'contexttype' => 4, 'name' => 'Powerpoint', 'icon' => NULL, 'image' => 'pptx', 'function' => 'pptx', 'shortcut' => NULL, 'sort_order' => 3, 'status' => 1],
            ['id' => 4, 'contexttype' => 4, 'name' => 'Text', 'icon' => NULL, 'image' => 'txt', 'function' => 'txt', 'shortcut' => NULL, 'sort_order' => 4, 'status' => 1],
            ['id' => 5, 'contexttype' => 5, 'name' => 'Tiny Icon', 'icon' => '<i class="ri-function-add-line ri-xs"></i>', 'image' => '', 'function' => 'tiny', 'shortcut' => NULL, 'sort_order' => 1, 'status' => 1],
            ['id' => 6, 'contexttype' => 5, 'name' => 'Small Icon', 'icon' => '<i class="ri-function-add-line ri-sm"></i>', 'image' => '', 'function' => 'small', 'shortcut' => NULL, 'sort_order' => 2, 'status' => 1],
            ['id' => 7, 'contexttype' => 5, 'name' => 'Medium Icon', 'icon' => '<i class="ri-function-add-line ri-1x"></i>', 'image' => '', 'function' => 'medium', 'shortcut' => NULL, 'sort_order' => 3, 'status' => 1],
            ['id' => 8, 'contexttype' => 5, 'name' => 'Big Icon', 'icon' => '<i class="ri-function-add-line ri-lg"></i>', 'image' => '', 'function' => 'big', 'shortcut' => NULL, 'sort_order' => 4, 'status' => 1],
            ['id' => 9, 'contexttype' => 5, 'name' => 'Oversize Icon', 'icon' => '<i class="ri-function-add-line ri-xl"></i>', 'image' => '', 'function' => 'oversize', 'shortcut' => NULL, 'sort_order' => 5, 'status' => 1],
            ['id' => 10, 'contexttype' => 12, 'name' => 'Name', 'icon' => NULL, 'image' => NULL, 'function' => 'name-asc', 'shortcut' => NULL, 'sort_order' => 2, 'status' => 1],
            ['id' => 11, 'contexttype' => 12, 'name' => 'Type', 'icon' => NULL, 'image' => NULL, 'function' => 'extension-asc', 'shortcut' => NULL, 'sort_order' => 3, 'status' => 1],
            ['id' => 12, 'contexttype' => 12, 'name' => 'Creation', 'icon' => NULL, 'image' => NULL, 'function' => 'created_at-asc', 'shortcut' => NULL, 'sort_order' => 4, 'status' => 1],
            ['id' => 13, 'contexttype' => 12, 'name' => 'Modification', 'icon' => NULL, 'image' => NULL, 'function' => 'updated_at-asc', 'shortcut' => NULL, 'sort_order' => 5, 'status' => 1]           
        ]);
    }
}
