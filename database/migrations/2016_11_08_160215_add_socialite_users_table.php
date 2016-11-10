<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialiteUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('wechat_openid', 100)->nullable()->after('last_login')->unique();
            $table->string('wechat_access_token', 100)->nullable()->after('wechat_openid');
            $table->string('wechat_unionid', 100)->nullable()->after('wechat_access_token');
            
            $table->string('facebook_openid', 100)->nullable()->after('wechat_unionid')->unique();
            $table->string('facebook_access_token', 100)->nullable()->after('facebook_openid');
            
            $table->string('instagram_openid', 100)->nullable()->after('facebook_access_token')->unique();
            $table->string('instagram_access_token', 100)->nullable()->after('instagram_openid');
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
            $table->dropColumn([
                'wechat_openid', 'wechat_access_token', 'wechat_unionid',
                'facebook_openid', 'facebook_access_token',
                'instagram_openid', 'instagram_access_token',
            ]);
        });
    }
}
