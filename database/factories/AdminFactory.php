<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use App\Models\Roles;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin>
 */
class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'admin_name' => $this->faker->name(),
            'admin_email' => $this->faker->unique()->safeEmail(),
            'admin_phone' => $this->faker->phoneNumber(),
            'admin_password' => md5('password'), // Mật khẩu mặc định
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Admin $admin) {
            
            $roles = Roles::where('name', 'user')->get(); // Lấy danh sách role
            $admin->roles()->sync($roles->pluck('id_roles')->toArray()); // Gắn role vào admin
        });
    }

    
}