<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIlikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('ilike', function(Blueprint $table)
		{
			// columns
			$table->integer('stuff_id');
			$table->integer('user_id');
            
			// indexes
			$table->index(array('stuff_id', 'user_id'));
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ilike');
    }
}
