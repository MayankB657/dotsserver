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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->nullable()->constrained('files')->cascadeOnDelete();
            $table->text('message')->nullable();
            $table->string('sender')->nullable();
            $table->string('receiver_id')->nullable();
            $table->string('receiver_type')->nullable();
            $table->string('parent')->nullable()->default(0);
            $table->string('status')->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
