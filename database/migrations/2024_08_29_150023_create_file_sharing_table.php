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
        Schema::create('file_sharing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('files_id')->nullable()->constrained('files')->cascadeOnDelete();
            $table->foreignId('folders_id')->nullable()->constrained('files')->cascadeOnDelete();
            $table->foreignId('sharedby_users_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('url')->nullable();
            $table->string('password')->nullable();
            $table->dateTime('expiry')->nullable();
            $table->bigInteger('views')->default(0)->nullable();
            $table->bigInteger('downloads')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_sharing');
    }
};
