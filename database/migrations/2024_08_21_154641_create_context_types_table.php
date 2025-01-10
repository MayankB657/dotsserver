<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContextTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('context_types', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('icon')->nullable();
            $table->text('function')->nullable();
            $table->boolean('is_options')->default(false);
            $table->enum('show_on', ['app', 'rightclick', 'file', 'recyclebin', 'all'])->default('all');
            $table->text('conditional')->nullable();
            $table->text('shortcut')->nullable();
            $table->boolean('display_header')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(1);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('context_types');
    }
}
?>