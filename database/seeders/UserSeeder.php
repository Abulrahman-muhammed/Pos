<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use  App\Enums\UserStatusEnum;
use App\Models\User;  
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'username'=>'admin'
        ],[
            'username' => 'admin',
            'password' => bcrypt('123123'),
            'full_name'=> 'administrator',
            'status'   => UserStatusEnum::Active->value,
        ]);
        // User::factory(5000)->create();

    }
}
