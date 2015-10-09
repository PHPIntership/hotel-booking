<?php

use Illuminate\Database\Seeder;
use HotelBooking\AdminHotel;

/**
 * Seeder class for admin_hotels table
 */
class AdminHotelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i=1; $i < 10; $i++) {
            AdminHotel::create([
                'hotel_id' => rand(1,9),
                'username' => 'hoteladmin'.$i,
                'password' => '123123',
                'name' =>$faker->name,
                'email' =>$faker->email,
                'phone' =>$faker->phoneNumber
            ]);
        }
    }
}
