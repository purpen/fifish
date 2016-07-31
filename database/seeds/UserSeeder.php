<?php

use Illuminate\Database\Seeder;

use App\Http\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
           'username' => 'purpen',
           'account'  => 'purpen.w@gmail.com',
           'password' => bcrypt('456321')
        ]);
    }
}
