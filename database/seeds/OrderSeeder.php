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
        for ($i = 1; $i < 200; ++$i) {
            Order::create([
                'user_id' => $i%9+1,
                'hotel_room_type_id' => $i%9+1,
                'coming_date' => $faker->date,
                'leave_date' => $faker->date,
                'price' => rand(1, 100),
                'quantity' => rand(1, 5),
                'status' => ($i%4),
            ]);
        }
    }
}
