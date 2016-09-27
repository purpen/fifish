<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('user_id');
                $table->integer('target_id');
                
                $table->text('content')->nullable();
                
                $table->integer('reply_user_id')->default(0);
                $table->integer('like_count')->default(0);
                
                $table->tinyInteger('type')->default(1);
                
                $table->timestamps();
                
                // 创建索引
                $table->index('target_id');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('comments');
    }
    
}
