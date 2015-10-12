<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;

class RoomTypeFormCreateTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * test form create room type.
     */
    public function testFormCreateRoomType()
    {
        $this->visit(route('admin.room-type.create'))
            ->see(trans('messages.create_room_type'));
    }

    /**
     * test form create when post room type.
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
     * test form create post room type without name and quality.
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
     * test form create post room type without name.
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
     * test form create post room type without quality.
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
}
