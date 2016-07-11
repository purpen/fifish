<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCaptchaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 创建captcha 验证码表
        Schema::create('captcha', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 6);
            $table->string('phone',11);
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->index(['code', 'phone', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
