<?php

use Illuminate\Database\Seeder;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('comments')->insert([
           'content'   => str_random(10).'_text',
           'user_id'   => str_random(10),
           'target_id' => str_random(100),
        ]);
    }
}
