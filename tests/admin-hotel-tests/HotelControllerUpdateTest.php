<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\Hotel;
use HotelBooking\City;

class HotelControllerUpdateTest extends TestCase
{
    use DatabaseTransactions;

    /**
     *Create a temporary hotel with Faker\Factory
     *
     *@return HotelBooking\Hotel.
     */
    private function createFakerHotel()
    {
        $faker = Faker\Factory::create();
        $city = City::create(['name' => $faker->name]);
        $request = [
            'name' => $faker->name,
            'city_id' => $city->id,
            'quality' => 3,
            'address' => $faker->address,
            'email' => $faker->email,
            'phone' => $faker->phonenumber,
            'description' => $faker->text,
        ];
        return Hotel::create($request);
    }

    /**
     *Test if a hotel is edited when issert valid data.
     */
    public function testNewHotelIsEdited()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('caraven.com.vn', '#website')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.edit_submit'))
            ->seeIndatabase('hotels', ['name' => 'Caraven'])
            ->seeIndatabase('hotels', ['quality' => '1'])
            ->seeIndatabase('hotels', ['address' => '123 Ly Thuong Kiet'])
            ->seeIndatabase('hotels', ['email' => 'testHotel@gmail.com'])
            ->seeIndatabase('hotels', ['phone' => '0987666223'])
            ->seeIndatabase('hotels', ['website' => 'caraven.com.vn'])
            ->seeIndatabase('hotels', ['description' => 'Super star Caraven Hotel'])
            ->see(trans('messages.edit_success_hotel'));
    }

    /**
     *Test if a hotel is edited when issert nochange.
     */
    public function testNewHotelIsEditedWithoutChange()
    {
        $faker = Faker\Factory::create();
        $city = City::create(['name' => $faker->name]);
        $request = [
            'name' => 'Caraven',
            'city_id' => $city->id,
            'quality' => 1,
            'address' => '123 Ly Thuong Kiet',
            'email' => 'testHotel@gmail.com',
            'phone' => '0987666223',
            'description' => 'Super star Caraven Hotel',
        ];
        $hotel = Hotel::create($request);
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->press(trans('messages.edit_submit'))
            ->see(trans('messages.edit_success_hotel'));
    }

    /**
     * Test if a hotel cant be edited when issert null name.
     */
    public function testEditHotelWithoutName()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('', '#name')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.required', ['attribute' => 'name']));
    }

    /**
     * Test if a hotel cant be edited when issert null quality.
     */
    public function testEditHotelWithoutQuality()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('', '#quality')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.required', ['attribute' => 'quality']));
    }

    /**
     * Test if a hotel cant be edited when issert null address.
     */
    public function testEditHotelWithoutAddress()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('', '#address')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.required', ['attribute' => 'address']));
    }

    /**
     * Test if a hotel cant be edited when issert null email.
     */
    public function testEditHotelWithoutEmail()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('', '#email')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.required', ['attribute' => 'email']));
    }

    /**
     * Test if a hotel cant be edited when issert null phone.
     */
    public function testEditHotelWithoutPhone()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('', '#phone')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.required', ['attribute' => 'phone']));
    }

    /**
     * Test if a hotel cant be edited when issert null description.
     */
    public function testEditHotelWithoutDescription()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('', '#description')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.required', ['attribute' => 'description']));
    }

    /**
     * Test if a hotel cant be edited when issert name less
     * than 6 characters.
     */
    public function testEditHotelWithNameLessThan6Characters()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('Cara', '#name')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.min.string', [
                'attribute' => 'name',
                'min' => 6
                ]));
    }

    /**
     * Test if a hotel cant be edited when issert name more
     * than 30 characters.
     */
    public function testEditHotelWithNameMoreThan30Characters()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('Caravencccccccccccccccccccccccc', '#name')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.max.string', [
                'attribute' => 'name',
                'max' => 30
                ]));
    }

    /**
     * Test if a hotel cant be edited when issert name with wrong regex.
     */
    public function testEditHotelWithWrongRegexName()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('caraven', '#name')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.regex', ['attribute' => 'name']));
    }

    /**
     * Test if a hotel cant be edited when issert quality less
     * than 0.
     */
    public function testEditHotelWithQualityLessThan0()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('-1', '#quality')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.min.numeric', [
                'attribute' => 'quality',
                'min' => 0
                ]));
    }

    /**
     * Test if a hotel cant be edited when issert quality greater
     * than 10.
     */
    public function testEditHotelWithQualityGreaterThan10()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('11', '#quality')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.max.numeric', [
                'attribute' => 'quality',
                'max' => 10
                ]));
    }

    /**
     * Test if a hotel cant be edited when issert non-integer quality.
     */
    public function testEditHotelWithNonIntegerQuality()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('a', '#quality')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.integer', ['attribute' => 'quality']));
    }

    /**
     * Test if a hotel cant be edited when issert address less
     * than 6 characters.
     */
    public function testEditHotelWithAddressLessThan6Characters()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('123LT', '#address')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.min.string', [
                'attribute' => 'address',
                'min' => 6
                ]));
    }

    /**
     * Test if a hotel cant be edited when issert address more
     * than 50 characters.
     */
    public function testEditHotelWithAddressMoreThan50Characters()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('123 Ly Thuong Kiet llllllllllllllllllllllllllllllll', '#address')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.max.string', [
                'attribute' => 'address',
                'max' => 50
                ]));
    }

    /**
     * Test if a hotel cant be edited when issert address with wrong regex.
     */
    public function testEditHotelWithWrongRegexAddress()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('123(A) Ly Thuong Kiet', '#address')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.regex', ['attribute' => 'address']));
    }

    /**
     * Test if a hotel cant be edited when issert exists email.
     */
    public function testEditHotelWithExistsEmail()
    {
        $email = $this->createFakerHotel()->email;
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type($email, '#email')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.unique', ['attribute' => 'email']));
    }

    /**
     * Test if a hotel cant be edited when issert email less
     * than 10 characters.
     */
    public function testEditHotelWithEamailLessThan10Characters()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('ts@gm.com', '#email')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.min.string', [
                'attribute' => 'email',
                'min' => 10
                ]));
    }

    /**
     * Test if a hotel cant be edited when issert email more
     * than 30 characters.
     */
    public function testEditHotelWithEmailMoreThan30Characters()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('testHoteltttttttttttt@gmail.com', '#email')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.max.string', [
                'attribute' => 'email',
                'max' => 30
                ]));
    }

    /**
     * Test if a hotel cant be edited when issert invalid email.
     */
    public function testEditHotelWithInvalidEmail()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('testHotelgmail.com', '#email')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.email', ['attribute' => 'email']));
    }

    /**
     * Test if a hotel cant be edited when issert phone less
     * than 10 characters.
     */
    public function testEditHotelWithPhoneLessThan10Characters()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('098766622', '#phone')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.min.string', [
                'attribute' => 'phone',
                'min' => 10
                ]));
    }

    /**
     * Test if a hotel cant be edited when issert phone more
     * than 12 characters.
     */
    public function testEditHotelWithPhoneMoreThan12Characters()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('0987666223345', '#phone')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.max.string', [
                'attribute' => 'phone',
                'max' => 12
                ]));
    }

    /**
     * Test if a hotel cant be edited when issert phone with wrong regex.
     */
    public function testEditHotelWithWrongRegexPhone()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('1987666223', '#phone')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.regex', ['attribute' => 'phone']));
    }

    /**
     * Test if a hotel cant be edited when issert description less
     * than 10 characters.
     */
    public function testEditHotelWithDescriptionLessThan10Characters()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('Superstar', '#description')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.min.string', [
                'attribute' => 'description',
                'min' => 10
                ]));
    }

    /**
     * Test if a hotel cant be edited when issert description more
     * than 200 characters.
     */
    public function testEditHotelWithDescriptionMoreThan200Characters()
    {
        $description = 'Super star Caraven Hotelssssssssssssssssssssssssss';
        $description = $description.$description.$description.$description.'s';
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type($description, '#description')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.max.string', [
                'attribute' => 'description',
                'max' => 200
                ]));
    }

    /**
     * Test if a hotel cant be edited when issert description with wrong regex.
     */
    public function testEditHotelWithWrongRegexDescription()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('Super() star Caraven Hotel', '#description')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.regex', ['attribute' => 'description']));
    }

    /**
     * Test if a hotel cant be edited when issert website with wrong regex.
     */
    public function testEditHotelWithWrongRegexWebsite()
    {
        $hotel = $this->createFakerHotel();
        $this->visit(route('admin.hotel.edit', $hotel->id))
            ->type('caravencom', '#website')
            ->press(trans('messages.edit_submit'))
            ->see(trans('validation.regex', ['attribute' => 'website']));
    }
}
