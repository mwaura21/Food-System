<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CreateCustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $customer = [
            [
                'first_name' => 'Daniel',
                'last_name' => 'Mwaura',
                'email' => 'customer@onlinewebtutorblog.com',
                'phone_number' => '0745709501',
                'country' => '5',
                'city' => '3',
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($customer as $key => $value) {
            Customer::create($value);
        }
    }
}