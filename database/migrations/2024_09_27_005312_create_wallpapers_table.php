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
        Schema::create('wallpapers', function (Blueprint $table) {
            $table->id(); 
            $table->string('image'); 
            $table->boolean('type')->default(1)->comment('1 = Login wallpaper, 0 = Desktop wallpaper');
            $table->boolean('status')->default(1);
            $table->foreignId('created_by')->constrained('users'); 
            $table->boolean('default')->default(1)->comment('1 = Default wallpaper, 0 = uploaded by user');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallpapers');
    }
};
