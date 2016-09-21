<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function(Blueprint $table)
            {
                $table->increments('id');
                $table->string('name');
                $table->string('display_name');
                $table->string('description')->nullable();
                $table->string('index')->nullable();
                $table->integer('total_count')->default(0);
                
                // 推荐状态
                $table->tinyInteger('sticked')->default(0);
                $table->timestamp('sticked_at');
                
                $table->timestamps();
                
                // 创建索引
                $table->unique('name');
                $table->index('index');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tags');
    }
}
