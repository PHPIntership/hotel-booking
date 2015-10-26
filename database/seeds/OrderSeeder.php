<?php

use Illuminate\Database\Seeder;
use HotelBooking\Order;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $orders = array();
        for ($i = 1; $i < 10; ++$i) {
            Order::create([
                'user_id' => $i,
                'hotel_room_type_id' => $i,
                'coming_date' => $faker->date,
                'leave_date' => $faker->date,
                'price' => rand(1, 100),
                'quantity' => rand(1, 5),
                'status' => 0,
            ]);
        }
    }
}
