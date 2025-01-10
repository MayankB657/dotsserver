<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('file_sharing_roles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_sharing_id')->constrained('file_sharing')->cascadeOnDelete();
            $table->foreignId('roles_id')->nullable()->constrained('roles')->cascadeOnDelete();
            $table->tinyInteger('is_write')->default(0)->comment('1 = Yes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_sharing_roles');
    }
};
