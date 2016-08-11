<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function(Blueprint $table)
            {
                $table->increments('id');
                $table->integer('user_id');
                
                $table->integer('assetable_id');
                $table->string('assetable_type');
                
                // 原图信息
                $table->string('filepath');
                $table->string('filename');
                $table->float('size');
                $table->integer('width');
                $table->integer('height');
                $table->string('mime');
                
                $table->timestamps();
                
                // 状态
                $table->tinyInteger('state')->default(1);
                
                // 创建索引
                $table->index(['assetable_id','assetable_type']);
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('assets');
    }
}
