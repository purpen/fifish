<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColumnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('columns', function(Blueprint $table)
            {
                $table->increments('id');
                // 所属栏目位
                $table->integer('column_space_id');
                
                $table->integer('user_id');
                $table->string('title', 100);
                // 子标题
                $table->string('sub_title', 100)->nullable();
                $table->string('content', 1000)->nullable();
                // 简介
                $table->string('summary', 500)->nullable();
                $table->string('url', 200);
                
                $table->tinyInteger('type')->default(1);    // 位置：1.官网；2.APP；
                // 转向(用于app)：1.url；2.stuff详情；3.个人主页；4.－－；
                $table->tinyInteger('evt')->default(1);
                // 封面图ID
                $table->integer('cover_id')->nullable();

                $table->tinyInteger('status')->default(1);  // 发布状态：0.不显示；1.显示；
                
                // 栏目数量
                $table->integer('view_count')->default(0);
                // 排序
                $table->integer('order')->default(0);
                
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
        Schema::drop('columns');
    }
}
