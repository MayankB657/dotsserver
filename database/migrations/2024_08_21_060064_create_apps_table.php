<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('icon')->nullable();
            $table->string('app_function')->nullable();
            $table->text('link')->nullable();
            $table->text('type')->nullable();
            $table->tinyInteger('desktop_display')->default(1);
            $table->tinyInteger('filemanager_display')->default(0);
            $table->text('path')->nullable();
            $table->text('parentpath')->nullable();
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('apps');
    }
};
