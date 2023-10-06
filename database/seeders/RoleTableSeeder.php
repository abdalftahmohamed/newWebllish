<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'The Administrator', // optional
            'description' => 'can do any thing in project', // optional
        ]);

        $user = Role::create([
            'name' => 'user',
            'display_name' => 'normal user', // optional
            'description' => 'not paid any thing', // optional
        ]);

        $user = Role::create([
            'name' => 'Premium_user',
            'display_name' => 'Premium_user', // optional
            'description' => ' paid ', // optional
        ]);
    }
}
