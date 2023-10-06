<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'user',
            'email'=>'admin@admin.com',
            'password' => bcrypt('12345678'), // optional
            'country_id' => 2, // optional
            'city_id' => 4, // optional
            'type' => 'admin',
        ]);

    $user->addRole('admin');
}
}
