<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ContextTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('context_types')->insert([
            ['id' => 1, 'name' => 'Refresh', 'icon' => NULL, 'function' => 'refreshButton', 'is_options' => 0, 'show_on' => 'rightclick', 'conditional' => NULL, 'shortcut' => NULL, 'display_header' => 0, 'sort_order' => 1, 'status' => 1],
            ['id' => 2, 'name' => 'Upload', 'icon' => NULL, 'function' => 'uploadFiles', 'is_options' => 0, 'show_on' => 'rightclick', 'conditional' => NULL, 'shortcut' => NULL, 'display_header' => 1, 'sort_order' => 1, 'status' => 1],
            ['id' => 3, 'name' => 'New Folder', 'icon' => NULL, 'function' => 'createFolderFunction', 'is_options' => 0, 'show_on' => 'rightclick', 'conditional' => NULL, 'shortcut' => NULL, 'display_header' => 1, 'sort_order' => 1, 'status' => 1],
            ['id' => 4, 'name' => 'New File', 'icon' => NULL, 'function' => 'createFileFunction', 'is_options' => 1, 'show_on' => 'rightclick', 'conditional' => NULL, 'shortcut' => NULL, 'display_header' => 1, 'sort_order' => 1, 'status' => 1],
            ['id' => 5, 'name' => 'Icon Size', 'icon' => NULL, 'function' => 'resizeFunction', 'is_options' => 1, 'show_on' => 'rightclick', 'conditional' => NULL, 'shortcut' => NULL, 'display_header' => 1, 'sort_order' => 1, 'status' => 1],
            ['id' => 6, 'name' => 'Open', 'icon' => NULL, 'function' => 'openFunction', 'is_options' => 0, 'show_on' => 'all', 'conditional' => NULL, 'shortcut' => NULL, 'display_header' => 1, 'sort_order' => 1, 'status' => 1],
            ['id' => 7, 'name' => 'Cut', 'icon' => NULL, 'function' => 'cutFunction', 'is_options' => 0, 'show_on' => 'file', 'conditional' => NULL, 'shortcut' => NULL, 'display_header' => 1, 'sort_order' => 1, 'status' => 1],
            ['id' => 8, 'name' => 'Copy', 'icon' => NULL, 'function' => 'copyFunction', 'is_options' => 0, 'show_on' => 'file', 'conditional' => NULL, 'shortcut' => NULL, 'display_header' => 1, 'sort_order' => 1, 'status' => 1],
            ['id' => 9, 'name' => 'Rename', 'icon' => NULL, 'function' => 'renameFunction', 'is_options' => 0, 'show_on' => 'file', 'conditional' => NULL, 'shortcut' => NULL, 'display_header' => 1, 'sort_order' => 1, 'status' => 1],
            ['id' => 10, 'name' => 'Share', 'icon' => NULL, 'function' => 'shareFunction', 'is_options' => 0, 'show_on' => 'file', 'conditional' => NULL, 'shortcut' => NULL, 'display_header' => 1, 'sort_order' => 1, 'status' => 1],
            ['id' => 11, 'name' => 'Delete', 'icon' => NULL, 'function' => 'deleteFunction', 'is_options' => 0, 'show_on' => 'file', 'conditional' => NULL, 'shortcut' => NULL, 'display_header' => 1, 'sort_order' => 1, 'status' => 1],
            ['id' => 12, 'name' => 'Sort Order', 'icon' => NULL, 'function' => 'sortFunction', 'is_options' => 1, 'show_on' => 'rightclick', 'conditional' => NULL, 'shortcut' => NULL, 'display_header' => 1, 'sort_order' => 1, 'status' => 1],
            ['id' => 13, 'name' => 'Paste', 'icon' => NULL, 'function' => 'pasteFunction', 'is_options' => 0, 'show_on' => 'rightclick', 'conditional' => 'copyfilepath', 'shortcut' => NULL, 'display_header' => 1, 'sort_order' => 1, 'status' => 1],
             ['id' => 14, 'name' => 'Restore', 'icon' => NULL, 'function' => 'restoreFunction', 'is_options' => 0, 'show_on' => 'recyclebin', 'conditional' => 'restorepath', 'shortcut' => NULL, 'display_header' => 1, 'sort_order' => 1, 'status' => 1],
              ['id' => 15, 'name' => 'Delete', 'icon' => NULL, 'function' => 'deleteFunction', 'is_options' => 0, 'show_on' => 'recyclebin', 'conditional' => 'deletepath', 'shortcut' => NULL, 'display_header' => 1, 'sort_order' => 1, 'status' => 1]
        ]);
    }
}
