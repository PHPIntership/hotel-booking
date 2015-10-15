<?php

use Illuminate\Database\Seeder;
use HotelBooking\User;

/**
 * Seeder for users table
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i=1; $i < 10 ; $i++) {
            User::create([
                'username' => 'user0'.$i,
                'password' => '123123',
                'name' => $faker->name,
                'address' => $faker->address,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'image' => $faker->text(20)
            ]);
        }
    }
}
