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
		Schema::create('stuff_tag', function(Blueprint $table)
		{
			// columns
			$table->integer('stuff_id');
			$table->integer('tag_id');
            
			// indexes
			$table->index(array('stuff_id', 'tag_id'));
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stuff_tag');
    }
}
