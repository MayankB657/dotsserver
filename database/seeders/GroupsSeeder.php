<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupsSeeder extends Seeder
{
    public function run(): void
    {
        Group::create([
            'id' => 1,
            'name' => 'Administrator',
            'parentID' => NULL,
            'parentLevel' => NULL,
            'extraField' => NULL,
            'sort' => 1,
            'sizeMax' => 250,
            'sizeUse' => 250,
            'permissionID' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Group::create([
            'id' => 2,
            'name' => 'HR',
            'parentID' => NULL,
            'parentLevel' => NULL,
            'extraField' => NULL,
            'sort' => NULL,
            'sizeMax' => NULL,
            'sizeUse' => 300,
            'permissionID' => 3,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Group::create([
            'id' => 3,
            'name' => 'Normal',
            'parentID' => NULL,
            'parentLevel' => NULL,
            'extraField' => NULL,
            'sort' => NULL,
            'sizeMax' => NULL,
            'sizeUse' => 300,
            'permissionID' => 5,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        Group::create([
            'id' => 4,
            'name' => 'Tester',
            'parentID' => NULL,
            'parentLevel' => NULL,
            'extraField' => NULL,
            'sort' => NULL,
            'sizeMax' => NULL,
            'sizeUse' => 200,
            'permissionID' => 1,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
