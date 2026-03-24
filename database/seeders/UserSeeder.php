<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'first_name' => 'User',
            'last_name' => 'User',
            'email' => 'user@gmail.com',
            'password' => bcrypt('12345678'),
            'connect_account_id' => 'acct_1O2JtCFM7VrSpgSB',
            'type' => USER_TYPES['user'],
        ]);

    }
}
