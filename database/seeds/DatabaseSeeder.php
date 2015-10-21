<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AdminHotelTableSeeder::class);
        $this->call(HotelRoomTypeSeeder::class);
        $this->call(HotelTableSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}
