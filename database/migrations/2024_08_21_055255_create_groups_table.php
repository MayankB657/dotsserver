<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('parentID')->nullable();
            $table->string('parentLevel')->nullable();
            $table->string('extraField')->nullable();
            $table->integer('sort')->nullable();
            $table->double('sizeMax')->nullable()->default(2);
            $table->integer('sizeUse')->nullable()->default(1);
            $table->foreignId('permissionID')->nullable()->constrained('permissions')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
