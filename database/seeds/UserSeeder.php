<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
           'account' => str_random(100).'@taihuoniao.com',
           'password' => sha1(str_random(40).'-tag'),
           'nickname' => str_random(100).'_ok', 
        ]);
    }
}
