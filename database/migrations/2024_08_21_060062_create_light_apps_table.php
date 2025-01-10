<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('light_apps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('group')->nullable()->constrained('light_app_categories')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('link')->nullable();
            $table->string('description')->nullable();
            $table->text('function')->nullable();
            $table->string('fileextension')->nullable();
            $table->string('icon')->nullable();
            $table->unsignedInteger('open_type')->default(0);
            $table->integer('width')->default(700);
            $table->integer('height')->default(700);
            $table->integer('sort_order')->default(0);
            $table->tinyInteger('status')->default(1);
            $table->integer('add_app')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('light_apps');
    }
};
