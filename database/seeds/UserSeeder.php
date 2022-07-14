<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        User::create([
            'UsernameKP' => 'grandresidence',
            'PasswordKP' => bcrypt('Residence123'),
            'Email' => 'grandresidencecity@gmail.com',
            'LevelUserID' => 'admin_int'
         ]);
    }
}
