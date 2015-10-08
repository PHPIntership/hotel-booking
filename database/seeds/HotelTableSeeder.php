<?php

use Illuminate\Database\Seeder;
use HotelBooking\Hotel;
use HotelBooking\City;

/**
 * Seeder class for seeding hotels table
 */
class HotelTableSeeder extends Seeder
{
    /**
     * Seed hotels and cities table for testing.
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        for ($i = 0; $i < 10; ++$i) {
            Hotel::create([
                'city_id' => rand(1, 9),
                'name' => $faker->name,
                'quality' => rand(1, 5),
                'address' => $faker->address,
                'phone' => $faker->phoneNumber,
                'email' => $faker->email,
                'website' => $faker->domainName,
                'image' => $faker->text(20),
                'description' => $faker->text,
            ]);
        }

        for ($i = 1; $i < 10; ++$i) {
            City::create([
                'id' => $i,
                'name' => $faker->city,
            ]);
        }
    }
}
