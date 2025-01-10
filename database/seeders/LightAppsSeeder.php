<?php

namespace Database\Seeders;

use App\Models\LightApp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LightAppsSeeder extends Seeder
{
    public function run(): void
    {
        LightApp::create([
            'id' => 1,
            'group' => 1,
            'name' => 'Docx',
            'link' => '',
            'description' => NULL,
            'function' => 'createdocument',
            'fileextension' => 'docx',
            'icon' => 'docx.svg',
            'open_type' => 1,
            'width' => 700,
            'height' => 700,
            'sort_order' => 0,
            'status' => 1,
            'add_app' => 1,
            'created_at' => '2024-06-02 14:27:35',
            'updated_at' => '2024-06-02 14:27:35'
        ]);

        LightApp::create([
            'id' => 2,
            'group' => 1,
            'name' => 'PPT',
            'link' => '',
            'description' => NULL,
            'function' => 'createdocument',
            'fileextension' => 'pptx',
            'icon' => 'ppt.svg',
            'open_type' => 1,
            'width' => 700,
            'height' => 700,
            'sort_order' => 0,
            'status' => 1,
            'add_app' => 1,
            'created_at' => '2024-06-02 14:27:35',
            'updated_at' => '2024-06-02 14:27:35'
        ]);

        LightApp::create([
            'id' => 3,
            'group' => 1,
            'name' => 'EXCEL',
            'link' => '',
            'description' => NULL,
            'function' => 'createdocument',
            'fileextension' => 'xlsx',
            'icon' => 'excel.svg',
            'open_type' => 1,
            'width' => 700,
            'height' => 700,
            'sort_order' => 0,
            'status' => 1,
            'add_app' => 1,
            'created_at' => '2024-06-02 14:27:35',
            'updated_at' => '2024-06-02 14:27:35'
        ]);

        LightApp::create([
            'id' => 4,
            'group' => 1,
            'name' => 'Chat',
            'link' => 'https://zulip.sizaf.com/',
            'description' => NULL,
            'function' => NULL,
            'fileextension' => NULL,
            'icon' => 'chat.svg',
            'open_type' => 1,
            'width' => 700,
            'height' => 700,
            'sort_order' => 0,
            'status' => 1,
            'add_app' => 1,
            'created_at' => '2024-06-02 14:27:35',
            'updated_at' => '2024-06-02 14:27:35'
        ]);

        LightApp::create([
            'id' => 5,
            'group' => 1,
            'name' => 'Erp',
            'link' => 'https://erp.sizaf.com/login#login',
            'description' => NULL,
            'function' => NULL,
            'fileextension' => NULL,
            'icon' => 'erp.svg',
            'open_type' => 1,
            'width' => 700,
            'height' => 700,
            'sort_order' => 0,
            'status' => 1,
            'add_app' => 1,
            'created_at' => '2024-06-02 14:27:35',
            'updated_at' => '2024-06-02 14:27:35'
        ]);

        LightApp::create([
            'id' => 6,
            'group' => 1,
            'name' => 'Mail',
            'link' => 'https://snappymail.sizaf.com/',
            'description' => NULL,
            'function' => NULL,
            'fileextension' => NULL,
            'icon' => 'mail.svg',
            'open_type' => 1,
            'width' => 700,
            'height' => 700,
            'sort_order' => 0,
            'status' => 1,
            'add_app' => 1,
            'created_at' => '2024-06-02 14:27:35',
            'updated_at' => '2024-06-02 14:27:35'
        ]);

        LightApp::create([
            'id' => 7,
            'group' => 1,
            'name' => 'Social',
            'link' => 'https://social.sizaf.com/html/user/login',
            'description' => NULL,
            'function' => NULL,
            'fileextension' => NULL,
            'icon' => 'social.svg',
            'open_type' => 1,
            'width' => 700,
            'height' => 700,
            'sort_order' => 0,
            'status' => 1,
            'add_app' => 1,
            'created_at' => '2024-06-02 14:27:35',
            'updated_at' => '2024-06-02 14:27:35'
        ]);

        LightApp::create([
            'id' => 8,
            'group' => 1,
            'name' => 'Documents',
            'link' => 'https://dev-ubt-app06.dev.orientdots.net',
            'description' => NULL,
            'function' => NULL,
            'fileextension' => NULL,
            'icon' => 'help-64.png',
            'open_type' => 1,
            'width' => 700,
            'height' => 700,
            'sort_order' => 0,
            'status' => 1,
            'add_app' => 1,
            'created_at' => '2024-06-02 14:27:35',
            'updated_at' => '2024-06-02 14:27:35'
        ]);
    }
}
