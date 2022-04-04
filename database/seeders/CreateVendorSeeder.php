<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;

class CreateVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendor = [
            [
                'name' => 'Foood',
                'logo' => 'food.jpg',
                'email' => 'vendor@onlinewebtutorblog.com',
                'phone_number' => '0745709501',
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($vendor as $key => $value) {
            Vendor::create($value);
        }
    }
}