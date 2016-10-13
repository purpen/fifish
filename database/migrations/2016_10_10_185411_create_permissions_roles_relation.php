<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionsRolesRelation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_role', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->integer('permission_id')->unsigned();
            $table->integer('role_id')->unsigned();
            
            $table->primary(['permission_id', 'role_id']);        
        });
        
        Schema::create('role_user', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            
            $table->primary(['role_id', 'user_id']);      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('permission_role');
        Schema::drop('role_user');
    }
}
