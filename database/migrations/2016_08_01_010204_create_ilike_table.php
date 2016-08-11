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
		Schema::create('likes', function(Blueprint $table)
		{
			// columns
            $table->increments('id');
			$table->integer('user_id');
            
            $table->integer('likeable_id');
            $table->string('likeable_type');
            
            $table->timestamps();
            
			// 添加主键索引
			$table->unique(['likeable_id', 'likeable_type', 'user_id']);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
