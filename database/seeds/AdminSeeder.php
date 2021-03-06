<?php

use App\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Administrator',
            'email'=> 'admin@gmail.com',
            'password' => bcrypt('12345678'),
            'level' => 2,
            'status' => 1
        ]);
    }
}
