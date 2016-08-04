<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStuffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stuffs', function(Blueprint $table)
            {
                $table->increments('id');
                
                $table->integer('user_id');
                
                // 关联附件Id
                $table->integer('asset');
                $table->text('content');
                $table->string('tags');
                
                // 推荐状态
                $table->tinyInteger('sticked')->default(1);
                $table->timestamp('sticked_at');
                
                // 精选
                $table->tinyInteger('featured')->default(1);
                $table->timestamp('featured_at');
                
                $table->integer('view_count')->default(0);
                $table->integer('like_count')->default(0);
                $table->integer('comment_count')->default(0);
                $table->integer('share_count')->default(0);
                
                // 新增一个 deleted_at 列 用于软删除.
                $table->softDeletes();
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
        Schema::drop('stuffs');
    }
}
