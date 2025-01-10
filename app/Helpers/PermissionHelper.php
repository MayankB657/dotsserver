<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Roles;
use App\Models\Permissions;


class PermissionHelper
{
    public static function getFilteredPermissions($userId)
    {
        $getUsr = User::where('id', $userId)->first();

        // Initialize an empty filteredPermissions array
        $filteredPermissions = [
            'fileManager' => [],
            'userManagement' => [],
            'roleManagement' => [],
            'groupsManagement' => [],
            'backendManagement' => [],
            // 'desktopDownload' => [],
        ];

        

        return $filteredPermissions;
    }
}
