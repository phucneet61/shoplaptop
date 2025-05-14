<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Roles;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // Admin::factory(10)->create(); // Tạo 10 bản ghi giả cho Admin
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
