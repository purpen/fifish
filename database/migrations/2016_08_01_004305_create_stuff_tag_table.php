<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStuffTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('taggables', function(Blueprint $table)
		{
			// columns
            $table->integer('tag_id');
			$table->integer('taggable_id');
			$table->string('taggable_type');
            
            $table->timestamp('updated_at');
            
			// indexes
			$table->primary(['tag_id', 'taggable_id', 'taggable_type']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('taggables');
    }
}
