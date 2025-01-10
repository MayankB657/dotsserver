<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->string('user_image')->nullable();
            $table->timestamp('login_time')->useCurrent();
            $table->string('system')->nullable();
            $table->string('system_version')->nullable();
            $table->string('system_image')->nullable();
            $table->string('browser')->nullable();
            $table->string('browser_image')->nullable();
            $table->string('login_address')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_logs');
    }
};
