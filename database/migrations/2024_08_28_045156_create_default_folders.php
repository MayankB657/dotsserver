<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class CreateDefaultFolders extends Migration
{
    public function up()
    {
        // Define the directories you want to create
        $directories = [
            'Desktop',
            'Document',
            'Download',
            'RecycleBin',
            'Gallery'
        ];

        // Create directories
        foreach ($directories as $directory) {
            $path = storage_path("app/root/{$directory}");
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        }
    }

    public function down()
    {
        // Optionally, you can define how to remove these directories if needed
        $directories = [
            'Desktop',
            'Documents',
            'Downloads',
            'RecycleBin',
            'Gallery'
        ];

        // Remove directories
        foreach ($directories as $directory) {
            $path = storage_path("app/root/{$directory}");
            if (file_exists($path)) {
                rmdir($path);
            }
        }
    }
}
?>
