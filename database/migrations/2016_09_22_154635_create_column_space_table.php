<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnSpaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('column_spaces', function(Blueprint $table)
            {
                $table->increments('id');
                
                $table->integer('user_id');
                $table->string('name', 100);
                $table->string('summary', 500)->nullable();
                
                $table->tinyInteger('type')->default(1);    // 位置：1.官网；2.APP；
                $table->tinyInteger('status')->default(1);  // 状态：0.不显示；1.显示；
                
                // 栏目数量
                $table->integer('count')->default(0);   
                $table->integer('width')->default(0);
                $table->integer('height')->default(0);
                
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
        Schema::drop('column_spaces');
    }
}
