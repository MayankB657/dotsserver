<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notice', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->longText('content')->nullable();
            $table->enum('send_to',['Everyone','Users','Groups','Role'])->nullable();
            $table->tinyInteger('is_schedule')->default(0);
            $table->dateTime('schedule_time')->nullable();
            $table->dateTime('send_at')->nullable();
            $table->enum('type',['Weak hint','Strong prompt'])->default('Weak hint');
            $table->tinyInteger('is_enable')->default(1)->comment('1 = Yes, 0 = No');
            $table->tinyInteger('is_send')->default(0)->comment('1 = Yes, 0 = No');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notice');
    }
};
