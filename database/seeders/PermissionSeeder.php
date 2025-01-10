<?php

namespace Database\Seeders;

use App\Models\Permissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {        
        Permissions::create([
            'id' => 1,
            'name' => 'Admin',
            'permissions' => 'view,preview,download,upload,edit,delete,share,comments,dynamic,admin,user-create,user-edit,user-view,user-delete,user-mass-upload,user-rollback,user-permanent-delete,role-create,role-edit,role-view,role-delete,role-mass-upload,role-rollback,role-permanent-delete,group-create,group-edit,group-view,group-delete,group-mass-upload,group-rollback,group-permanent-delete,notice,storage,backups,logs,search,new-file,move,compress,decompress',
            'created_at' => '2024-05-29 23:17:41',
            'updated_at' => '2024-05-29 23:17:41'
        ]);


        Permissions::create([
            'id' => 2,
            'name' => 'owner',
            'permissions' => 'preview,search,download,new-file,upload,share,edit,delete,move,compress,decompress',
            'created_at' => '2024-05-29 23:18:04',
            'updated_at' => '2024-05-29 23:18:04'
        ]);
        Permissions::create([
            'id' => 3,
            'name' => 'Edit / Uploader',
            'permissions' => 'preview,download,upload,edit',
            'created_at' => '2024-05-30 00:39:35',
            'updated_at' => '2024-05-30 00:49:45'
        ]);
        Permissions::create([
            'id' => 4,
            'name' => 'Master',
            'permissions' => 'file-manage,preview,search,download,new-file,upload,share,edit,delete,comments,dynamic,admin',
            'created_at' => '2024-06-10 22:48:16',
            'updated_at' => '2024-06-10 22:48:16'
        ]);
        Permissions::create([
            'id' => 5,
            'name' => 'sizaf',
            'permissions' => 'file-manage,preview,search,download,upload,share,edit,delete',
            'created_at' => '2024-08-05 00:03:46',
            'updated_at' => '2024-08-05 00:03:46'
        ]);
    }
}
