<?php

use App\UserMenu;
use Illuminate\Database\Seeder;

class UserMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $data = [
            ['user_id' => 68, 'menu_id' => 1],
            ['user_id' => 68, 'menu_id' => 2]
        ];

        foreach($data as $row){
            UserMenu::create($row);
        }
    }
}
