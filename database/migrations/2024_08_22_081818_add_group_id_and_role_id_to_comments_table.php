<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id')->nullable()->after('receiver_type');
            $table->unsignedBigInteger('role_id')->nullable()->after('group_id');
            // references
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('set null');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropForeign(['role_id']);
            $table->dropColumn(['group_id', 'role_id']);
        });
    }
};
