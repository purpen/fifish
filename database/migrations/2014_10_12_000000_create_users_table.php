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
            $table->string('account',20)->unique();
            $table->string('nickname',20)->unique();
            $table->string('email',50)->unique()->nullable();
            $table->string('phone',20)->nulltable();
            $table->string('avatar_url',50)->nulltable();
            $table->string('password', 60);
            $table->tinyInteger('sex')->default(0); // 性别：0.保密；1.男；2.女
            $table->string('realname',20)->nullable();
            $table->string('summary',140)->nullable();  // 个性签名
            $table->tinyInteger('role_id')->default(1); // 权限：1.用户；5.编辑；7.管理员；9.超级管理员；
            $table->tinyInteger('status')->default(2);  // 状态：0.禁用；1.待审核；2.激活
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
