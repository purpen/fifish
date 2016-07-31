<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('follow', function(Blueprint $table)
		{
			// columns
            $table->increments('id');
			$table->integer('user_id');
            $table->integer('follow_id');
            
			// indexes
			$table->index('user_id');
            $table->index('follow_id');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('follow');
    }
}
