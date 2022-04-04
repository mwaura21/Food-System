<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class CreateAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            [
                'name' => 'Admin',
                'email' => 'admin@onlinewebtutorblog.com',
                'phone_number' => '0745709501',
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($admin as $key => $value) {
            Admin::create($value);
        }
    }
}