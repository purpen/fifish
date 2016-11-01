<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRemindUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('alert_fans_count')->default(0)->after('like_count');
            $table->integer('alert_like_count')->default(0)->after('like_count');
            $table->integer('alert_comment_count')->default(0)->after('like_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['alert_fans_count', 'alert_like_count', 'alert_comment_count']);
        });
    }
}
