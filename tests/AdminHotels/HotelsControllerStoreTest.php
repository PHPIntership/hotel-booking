<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\Hotel;
use HotelBooking\City;

class HotelsControllerStoreTest extends TestCase
{
    use DatabaseTransactions;

    /**
     *Test if a hotel is created when issert valid data.
     */
    public function testNewHotelIsCreated()
    {
        $faker = Faker\Factory::create();
        $request = [
            'name' => $faker->name,
        ];
        City::create($request);
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->seeIndatabase('hotels', ['name' => 'Caraven'])
            ->seeIndatabase('hotels', ['quality' => '1'])
            ->seeIndatabase('hotels', ['address' => '123 Ly Thuong Kiet'])
            ->seeIndatabase('hotels', ['email' => 'testHotel@gmail.com'])
            ->seeIndatabase('hotels', ['phone' => '0987666223'])
            ->seeIndatabase('hotels', ['description' => 'Super star Caraven Hotel'])
            ->see(trans('messages.create_success_hotel'));
    }

    /**
     * Test if a hotel cant be created when issert null name.
     */
    public function testCreateHotelWithoutName()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.required', ['attribute' => 'name']));
    }

    /**
     * Test if a hotel cant be created when issert null quality.
     */
    public function testCreateHotelWithoutQuality()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.required', ['attribute' => 'quality']));
    }

    /**
     * Test if a hotel cant be created when issert null address.
     */
    public function testCreateHotelWithoutAddress()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.required', ['attribute' => 'address']));
    }

    /**
     * Test if a hotel cant be created when issert null email.
     */
    public function testCreateHotelWithoutEmail()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.required', ['attribute' => 'email']));
    }

    /**
     * Test if a hotel cant be created when issert null phone.
     */
    public function testCreateHotelWithoutPhone()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.required', ['attribute' => 'phone']));
    }

    /**
     * Test if a hotel cant be created when issert null description.
     */
    public function testCreateHotelWithoutDescription()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.required', ['attribute' => 'description']));
    }

    /**
     * Test if a hotel cant be created when issert name less
     * than 6 characters.
     */
    public function testCreateHotelWithNameLessThan6Characters()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Cara', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.min.string', [
                'attribute' => 'name',
                'min' => 6
                ]));
    }

    /**
     * Test if a hotel cant be created when issert name more
     * than 30 characters.
     */
    public function testCreateHotelWithNameMoreThan30Characters()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caravencccccccccccccccccccccccc', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.max.string', [
                'attribute' => 'name',
                'max' => 30
                ]));
    }

    /**
     * Test if a hotel cant be created when issert name with wrong regex.
     */
    public function testCreateHotelWithWrongRegexName()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.regex', ['attribute' => 'name']));
    }

    /**
     * Test if a hotel cant be created when issert quality less
     * than 0.
     */
    public function testCreateHotelWithQualityLessThan0()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('-1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.min.numeric', [
                'attribute' => 'quality',
                'min' => 0
                ]));
    }

    /**
     * Test if a hotel cant be created when issert quality greater
     * than 10.
     */
    public function testCreateHotelWithQualityGreaterThan10()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('11', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.max.numeric', [
                'attribute' => 'quality',
                'max' => 10
                ]));
    }

    /**
     * Test if a hotel cant be created when issert non-integer quality.
     */
    public function testCreateHotelWithNonIntegerQuality()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('a', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.integer', ['attribute' => 'quality']));
    }

    /**
     * Test if a hotel cant be created when issert address less
     * than 6 characters.
     */
    public function testCreateHotelWithAddressLessThan6Characters()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123LT', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.min.string', [
                'attribute' => 'address',
                'min' => 6
                ]));
    }

    /**
     * Test if a hotel cant be created when issert address more
     * than 50 characters.
     */
    public function testCreateHotelWithAddressMoreThan50Characters()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet llllllllllllllllllllllllllllllll', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.max.string', [
                'attribute' => 'address',
                'max' => 50
                ]));
    }

    /**
     * Test if a hotel cant be created when issert address with wrong regex.
     */
    public function testCreateHotelWithWrongRegexAddress()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123(A) Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.regex', ['attribute' => 'address']));
    }

    /**
     * Test if a hotel cant be created when issert exists email.
     */
    public function testCreateHotelWithExistsEmail()
    {
        $faker = Faker\Factory::create();
        $request = [
            'name' => $faker->name,
            'city_id' => 1,
            'quality' => 3,
            'address' => $faker->address,
            'phone' => $faker->phonenumber,
            'email' => $faker->email,
            'description' => $faker->text,
        ];
        $email = Hotel::create($request)->email;
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type($email, '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.unique', ['attribute' => 'email']));
    }

    /**
     * Test if a hotel cant be created when issert email less
     * than 10 characters.
     */
    public function testCreateHotelWithEamailLessThan10Characters()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('ts@gm.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.min.string', [
                'attribute' => 'email',
                'min' => 10
                ]));
    }

    /**
     * Test if a hotel cant be created when issert email more
     * than 30 characters.
     */
    public function testCreateHotelWithEmailMoreThan30Characters()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHoteltttttttttttt@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.max.string', [
                'attribute' => 'email',
                'max' => 30
                ]));
    }

    /**
     * Test if a hotel cant be created when issert invalid email.
     */
    public function testCreateHotelWithInvalidEmail()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotelgmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.email', ['attribute' => 'email']));
    }

    /**
     * Test if a hotel cant be created when issert phone less
     * than 10 characters.
     */
    public function testCreateHotelWithPhoneLessThan10Characters()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('098766622', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.min.string', [
                'attribute' => 'phone',
                'min' => 10
                ]));
    }

    /**
     * Test if a hotel cant be created when issert phone more
     * than 12 characters.
     */
    public function testCreateHotelWithPhoneMoreThan12Characters()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223345', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.max.string', [
                'attribute' => 'phone',
                'max' => 12
                ]));
    }

    /**
     * Test if a hotel cant be created when issert phone with wrong regex.
     */
    public function testCreateHotelWithWrongRegexPhone()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('1987666223', '#phone')
            ->type('Super star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.regex', ['attribute' => 'phone']));
    }

    /**
     * Test if a hotel cant be created when issert description less
     * than 10 characters.
     */
    public function testCreateHotelWithDescriptionLessThan10Characters()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Superstar', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.min.string', [
                'attribute' => 'description',
                'min' => 10
                ]));
    }

    /**
     * Test if a hotel cant be created when issert description more
     * than 200 characters.
     */
    public function testCreateHotelWithDescriptionMoreThan200Characters()
    {
        $description = 'Super star Caraven Hotelssssssssssssssssssssssssss';
        $description = $description.$description.$description.$description.'s';
        $this->visit(route('admin.hotel.create'))
            ->type('Caravencccccccccccccccccccccccc', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type($description, '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.max.string', [
                'attribute' => 'description',
                'max' => 200
                ]));
    }

    /**
     * Test if a hotel cant be created when issert description with wrong regex.
     */
    public function testCreateHotelWithWrongRegexDescription()
    {
        $this->visit(route('admin.hotel.create'))
            ->type('Caraven', '#name')
            ->type('1', '#quality')
            ->type('123 Ly Thuong Kiet', '#address')
            ->type('testHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->type('Super() star Caraven Hotel', '#description')
            ->press(trans('messages.create_submit'))
            ->see(trans('validation.regex', ['attribute' => 'description']));
    }
}
