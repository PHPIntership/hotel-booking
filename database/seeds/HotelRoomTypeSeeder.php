<?php

use Illuminate\Database\Seeder;
use HotelBooking\RoomType;
use HotelBooking\HotelRoomType;

/**
 * Seeder class for hotel_room_types table
 */
class HotelRoomTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $room_types = array();

        for ($i = 1; $i < 10; ++$i) {
            $room_type = RoomType::create([
                'name' => $faker->name,
            ]);
            $room_types[] = $room_type;
        }

        for ($i = 1; $i < 10; ++$i) {
            HotelRoomType::create([
                'room_type_id' => rand(0, 8),
                'hotel_id' => $i,
                'name' => $faker->name,
                'quality' => 'room type quality'.$i,
                'quantity' => rand(1, 5),
                'price' => rand(1, 100),
                'image' => $faker->text(20),
                'description' => $faker->text,
            ]);
        }
    }
}
