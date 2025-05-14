<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Roles;
use DB;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();
        DB::table('admin_roles')->truncate(); // Xóa dữ liệu trong bảng trung gian
        $adminRoles = Roles::where('name', 'admin')->first();
        $authorRoles = Roles::where('name', 'author')->first();
        $userRoles = Roles::where('name', 'user')->first();

        $admin = Admin::create([
            'admin_name' => 'Admin',
            'admin_email' => 'phucadmin@yahoo.com',
            'admin_phone' => '0123456789',
            'admin_password' => md5('123456'),
        ]);
        $author = Admin::create([
            'admin_name' => 'Author',
            'admin_email' => 'phucauthor@yahoo.com',
            'admin_phone' => '0123456780',
            'admin_password' => md5('123456'),
        ]);
        $user = Admin::create([
            'admin_name' => 'User',
            'admin_email' => 'phucuser@yahoo.com',
            'admin_phone' => '0123456781',
            'admin_password' => md5('123456'),
        ]);

        $admin->roles()->attach($adminRoles);
        $author->roles()->attach($authorRoles);
        $user->roles()->attach($userRoles);

        // Use the new factory syntax
        Admin::factory(20)->create()->each(function ($admin) use ($userRoles) {
            $admin->roles()->attach($userRoles);
        });
    }
}
