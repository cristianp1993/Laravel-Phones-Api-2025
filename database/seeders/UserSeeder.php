<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'cristian_p_17@hotmail.com'],
            [
                'name' => 'Cristian',
                'password' => bcrypt('123456'),
            ]
        );
    }
}
