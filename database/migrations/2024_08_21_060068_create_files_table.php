<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('folder')->default(0);
            $table->string('name', 255)->nullable();
            $table->string('extension', 100)->nullable();
            $table->text('filetype')->nullable();
            $table->text('parentpath')->nullable();
            $table->text('path')->nullable();
            $table->integer('openwith')->nullable();
            $table->text('filehash')->nullable();
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('is_root')->default(0);
            $table->tinyInteger('is_share')->default(0);
            $table->integer('status')->comment('0=recycleBin, 1=Desktop, 2=masterRecycleBin');
            $table->foreignId('created_by')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
