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
                $table->string('description');
                $table->string('index');
                $table->integer('total_count')->default(0);
                
                // 关联附件Id
                $table->integer('asset_id');
                // 推荐状态
                $table->tinyInteger('sticked')->default(1);
                $table->timestamp('sticked_at');
                
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
