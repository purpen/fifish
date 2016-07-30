<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('account', 50)->unique();
            $table->string('username', 50)->unique();
            $table->string('password', 60);
            $table->string('email', 50)->unique()->nullable();
            $table->string('phone', 20)->nulltable();
            $table->string('avatar_url', 150)->nulltable();
            $table->string('job', 60)->nulltable();
            $table->string('zone', 100)->nulltable(); // 城市/地区
            $table->tinyInteger('sex')->default(0); // 性别：0.保密；1.男；2.女
            $table->string('summary', 140)->nullable();  // 个性签名
            // 权限：1.用户；5.编辑；7.管理员；9.超级管理员；
            $table->tinyInteger('role_id')->default(1); 
            
            ## Counter
            $table->integer('follow_count')->default(0);
            $table->integer('fans_count')->default(0);
            $table->integer('stuff_count')->default(0);
            $table->integer('like_count')->default(0);
            
            // 个人标签
            $table->string('tags', 140)->nullable();
            // 来源站点
            $table->tinyInteger('from_site')->default(1);
            // 状态：0.禁用；1.待审核；2.激活
            $table->tinyInteger('status')->default(2);
            
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
