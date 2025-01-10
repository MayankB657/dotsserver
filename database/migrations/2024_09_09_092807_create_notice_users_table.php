<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notice_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notice_id')->constrained('notice')->cascadeOnDelete();
            $table->foreignId('users_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notice_users');
    }
};
