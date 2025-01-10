<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContextOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('context_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contexttype')->nullable();
            $table->text('name')->nullable();
            $table->text('icon')->nullable();
            $table->string('image', 250)->nullable();
            $table->text('function')->nullable();
            $table->text('shortcut')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(1);
            $table->integer('status')->default(1);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('contexttype')->references('id')->on('context_types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('context_options');
    }
}
?>
