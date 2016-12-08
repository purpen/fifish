<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemindsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminds', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->integer('sender_id')->default(0);
            
            $table->integer('evt')->default(0);
            $table->string('content', 100)->nullable();
            
            // 所属关联
            $table->integer('remindable_id');
            $table->string('remindable_type');
            
            // 相关ID
            $table->integer('related_id')->default(0);
            $table->tinyInteger('readed')->default(0);
            $table->tinyInteger('from_site')->default(1);
            
            $table->timestamps();
            
            // 创建索引
            $table->index(['remindable_id', 'remindable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reminds');
    }
}
