<?php

use Illuminate\Database\Seeder;

class StuffTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('stuffs')->insert([
           'user_id' => 0,
           'description' => str_random(100).'-title',
           'tags' => str_random(40).'-tag', 
        ]);
    }
}
