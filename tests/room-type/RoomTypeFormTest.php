<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\RoomType;

class RoomTypeFormTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Create room type.
     *
     * @return HotelBooking\RoomType
     */
    public function createRoomType()
    {
        $faker = Faker\Factory::create();
        $roomType = RoomType::create([
            'name' => $faker->name,
            'quality' => 'good',
        ]);

        return $roomType;
    }

    /**
     * Test form create room type.
     */
    public function testFormEditRoomType()
    {
        $roomType = $this->createRoomType();
        $this->visit(route('admin.room-type.edit', $roomType->id))
            ->see(trans('messages.edit_room_type'));
    }

    /**
     * Test form edit when post room type.
     */
    public function testFormPutEditRoomType()
    {
        $faker = Faker\Factory::create();
        $roomType = $this->createRoomType();
        $name = $faker->name;
        $this->visit(route('admin.room-type.edit', $roomType->id))
            ->type($name, 'name')
            ->type('bad', 'quality')
            ->press(trans('messages.update'))
            ->see(trans('messages.update_success'))
            ->seeIndatabase('room_types', ['name' => $name])
            ->dontsee('has-error');
    }

    /**
     * Test form create when post room type without name and quality.
     */
    public function testFormPutEditRoomTypeWithoutNameAndQuality()
    {
        $roomType = $this->createRoomType();
        $this->visit(route('admin.room-type.edit', $roomType->id))
            ->type('', 'name')
            ->type('', 'quality')
            ->press(trans('messages.update'))
            ->dontsee(trans('messages.update_success'))
            ->see(trans('validation.required', ['attribute' => 'name']))
            ->see(trans('validation.required', ['attribute' => 'quality']))
            ->see('has-error');
    }

    /**
     * Test form create when post room type without name and quality.
     */
    public function testFormPutEditRoomTypeWithoutName()
    {
        $roomType = $this->createRoomType();
        $this->visit(route('admin.room-type.edit', $roomType->id))
            ->type('', 'name')
            ->type('good', 'quality')
            ->press(trans('messages.update'))
            ->dontsee(trans('messages.update_success'))
            ->see(trans('validation.required', ['attribute' => 'name']))
            ->see('has-error');
    }

    /**
     * Test form create when post room type without name and quality.
     */
    public function testFormPutEditRoomTypeWithoutQuality()
    {
        $roomType = $this->createRoomType();
        $this->visit(route('admin.room-type.edit', $roomType->id))
            ->type('new room type', 'name')
            ->type('', 'quality')
            ->press(trans('messages.update'))
            ->dontsee(trans('messages.update_success'))
            ->see(trans('validation.required', ['attribute' => 'quality']))
            ->see('has-error');
    }
    /**
     * Test form create room type.
     */
    public function testFormCreateRoomType()
    {
        $this->visit(route('admin.room-type.create'))
            ->see(trans('messages.create_room_type'));
    }

    /**
     * Test form create when post room type.
     */
    public function testFormCreatePostRoomType()
    {
        $this->visit(route('admin.room-type.create'))
            ->type('New Room Type', 'name')
            ->type('good', 'quality')
            ->press(trans('messages.create'))
            ->see(trans('messages.create_success'))
            ->seeIndatabase('room_types', ['name' => 'New Room Type'])
            ->dontsee('has-error');
            //->type($faker->image($dir = '/tmp', $width = 640, $height = 480), 'image')
    }

    /**
     * Test form create post room type without name and quality.
     */
    public function testFormCreatePostRoomTypeWithoutNameAndQuality()
    {
        $this->visit(route('admin.room-type.create'))
            ->type('', 'name')
            ->type('', 'quality')
            ->press(trans('messages.create'))
            ->dontsee(trans('messages.create_success'))
            ->see(trans('validation.required', ['attribute' => 'name']))
            ->see(trans('validation.required', ['attribute' => 'quality']))
            ->see('has-error');
    }

    /**
     * Test form create post room type without name.
     */
    public function testFormCreatePostRoomTypeWithoutName()
    {
        $this->visit(route('admin.room-type.create'))
            ->type('', 'name')
            ->type('good', 'quality')
            ->press(trans('messages.create'))
            ->dontsee(trans('messages.create_success'))
            ->see(trans('validation.required', ['attribute' => 'name']))
            ->see('has-error');
    }

    /**
     * Test form create post room type without quality.
     */
    public function testFormCreatePostRoomTypeWithoutQuality()
    {
        $this->visit(route('admin.room-type.create'))
            ->type('new room type', 'name')
            ->type('', 'quality')
            ->press(trans('messages.create'))
            ->dontsee(trans('messages.create_success'))
            ->see(trans('validation.required', ['attribute' => 'quality']))
            ->see('has-error');
    }

    /**
     * Test Display a listing of the Room Type.
     *
     * @return void
     */
    public function testDisplayIndexRoomType()
    {
        $this->visit(route('admin.room-type.index'))
            ->see(trans('messages.room_type'));
            //trans('messages.delete')
    }

    /**
     * Test Delete Room Type
     *
     * @return void
     */
    public function testDeleteRoomTye()
    {
        $roomType = $this->createRoomType();
        $this->visit(route('admin.room-type.index'))
            ->press(trans('messages.delete'))
            ->see(trans('messages.delete_success'));
    }
}
