<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\AdminHotel;
use HotelBooking\AdminUser;

class AdminHotelControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Overide setUp function. Truncate and seed the database before tests.
     */
    public function setUp()
    {
        parent::setUp();
        static $seed = false;
        if (!$seed) {
            DB::table('admin_users')->truncate();
            $facAdminUser = factory(HotelBooking\AdminUser::class)->create();
            $adminUser = [
                'username'=>$facAdminUser->username,
                'password'=>'123456',
                'remember'=>1,
                '_token'  => csrf_token()
                ];
        }
        $this->actingAs();
    }

    /**
     * Override actingAs function for setting the current authenticated hotel admin.
     */
    public function actingAs($admin = null)
    {
        $admin = AdminUser::select('id', 'username', 'password')->first();
        $login = Auth::admin()->attempt([
            'username' => $admin->username,
            'password' => '123456',
        ]);
    }
    /**
     * Test display page index listing admin hotel.
     */
    public function testViewIndex()
    {
        $this->visit(route('admin-hotel.index'))
             ->see(trans('messages.admin_hotel'));
    }

    /**
     * Test status method GET display listing admin hotel.
     */
    public function testIndexStatus()
    {
        $response = $this->call('GET', '/admin-hotel');
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test status delete a admin hotel.
     */
    public function testDeleteAdminHotelStatusOk()
    {
        $faker = Faker\Factory::create();
        AdminHotel::create([
            'hotel_id' => rand(1, 9),
            'username' => $faker->firstName,
            'password' => bcrypt(str_random(10)),
            'name' => $faker->name,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
            ]);
        $adminHotel = AdminHotel::select('id')->first();
        $this->WithoutMiddleware();
        $response = $this->call('delete', route('admin-hotel.destroy', $adminHotel->id));
        $this->assertEquals(302, $response->status());
    }

    /**
     * Test status delete a admin hotel with id = 0 not exits in database.
     */
    public function testDeleteAdminHotelStatusFail()
    {
        $this->WithoutMiddleware();
        $response = $this->call('delete', route('admin-hotel.destroy', 0));
        $this->assertEquals(302, $response->status());
    }

    /**
     * Test if can get correct hotel admin create page status.
     */
    public function testCreateStatus()
    {
        $response = $this->call('GET', route('admin-hotel.create'));
        $this->assertResponseOk();
    }

    /**
     *Test if can get correct hotel admin store page status.
     */
    public function testStoreStatus()
    {
        $this->WithoutMiddleware();
        $this->call('POST', route('admin-hotel.store'));
        $this->assertResponseStatus(302);
    }

    /**
     *Test if can get correct  hotel admin edit page status.
     */
    public function testEditStatus()
    {
        $faker = Faker\Factory::create();
        AdminHotel::create([
            'hotel_id' => rand(0, 10),
            'username' => $faker->name,
            'name' => $faker->name,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
            'password' => str_random(10),
        ]);
        $adminHotel = AdminHotel::select('id')->first();
        $response = $this->call('GET', route('admin-hotel.edit', $adminHotel->id));
        $this->assertResponseOk();
        $this->assertViewHas('adminHotel');
    }

    /**
     *Test if can get correct  hotel admin update page status.
     */
    public function testUpdateStatus()
    {
        $this->WithoutMiddleware();
        $this->call('PUT', route('admin-hotel.update', 1));
        $this->assertResponseStatus(302);
    }

    /**
     *Test if a hotel admin is created when issert valid data.
     */
    public function testNewAdminHotelIsCreated()
    {
        $this->visit(route('admin-hotel.create'))
            ->type('hoteladmin892', '#username')
            ->type('123456', '#password')
            ->type('Justin Beiber', '#name')
            ->type('testAdminHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->press('Create')
            ->seeIndatabase('admin_hotels', ['email' => 'testAdminHotel@gmail.com'])
            ->seeIndatabase('admin_hotels', ['username' => 'hoteladmin892'])
            ->seeIndatabase('admin_hotels', ['name' => 'Justin Beiber'])
            ->seeIndatabase('admin_hotels', ['phone' => '0987666223'])
            ->see(trans('messages.create_success_admin_hotel'));
    }

    /**
     * Test if a hotel admin cant be created when issert null username.
     */
    public function testCreateAdminHotelWithoutUsername()
    {
        $this->visit(route('admin-hotel.create'))
            ->type('', '#username')
            ->type('123456', '#password')
            ->type('Justin Beiber', '#name')
            ->type('testAdminHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->press('Create')
            ->see(trans('validation.required', ['attribute' => trans('messages.username')]));
    }
    /**
     * Test if a hotel admin cant be created when issert a not unique username.
     */
    public function testCreateAdminHotelWithUniqueUsername()
    {
        $faker = Faker\Factory::create();
        AdminHotel::create([
            'hotel_id' => rand(0, 10),
            'username' => 'unique_username',
            'name' => $faker->name,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
            'password' => str_random(10),
        ]);
        $this->visit(route('admin-hotel.create'))
            ->type('unique_username', '#username')
            ->type('123123', '#password')
            ->type('BluePrint', '#name')
            ->type('testAdminHotel@gmail.com', '#email')
            ->type('0987777666', '#phone')
            ->press('Create')
            ->see(trans('validation.unique'), ['attribute' => trans('messages.name')]);
    }
    /**
     * Test if a hotel admin cant be created when issert null password.
     */
    public function testCreateAdminHotelWithoutPassword()
    {
        $this->visit(route('admin-hotel.create'))
            ->type('hoteladmin892', '#username')
            ->type('', '#password')
            ->type('Justin Beiber', '#name')
            ->type('testAdminHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->press('Create')
            ->see(trans('validation.required', ['attribute' => trans('messages.password')]));
    }

    /**
     * Test if a hotel admin cant be created when issert null name.
     */
    public function testCreateAdminHotelWithoutName()
    {
        $this->visit(route('admin-hotel.create'))
            ->type('hoteladmin892', '#username')
            ->type('123123', '#password')
            ->type('', '#name')
            ->type('testAdminHotel@gmail.com', '#email')
            ->type('0987666223', '#phone')
            ->press('Create')
            ->see(trans('validation.required', ['attribute' => trans('messages.name')]));
    }

    /**
     * Test if a hotel admin cant be created when issert null email.
     */
    public function testCreateAdminHotelWithoutEmail()
    {
        $this->visit(route('admin-hotel.create'))
            ->type('hoteladmin892', '#username')
            ->type('123123', '#password')
            ->type('BluePrint', '#name')
            ->type('', '#email')
            ->type('0987666223', '#phone')
            ->press('Create')
            ->see(trans('validation.required', ['attribute' => trans('messages.email')]));
    }

    /**
     * Test if a hotel admin cant be created when issert null phone.
     */
    public function testCreateAdminHotelWithoutPhone()
    {
        $this->visit(route('admin-hotel.create'))
            ->type('hoteladmin892', '#username')
            ->type('123123', '#password')
            ->type('BluePrint', '#name')
            ->type('testAdminHotel@gmail.com', '#email')
            ->type('', '#phone')
            ->press('Create')
            ->see(trans('validation.required', ['attribute' => trans('messages.phone')]));
    }

    /**
     * Test if a hotel admin cant be created when issert username less
     * than 6 characters.
     */
    public function testCreateAdminHotelWithUsernameLessThan6Characters()
    {
        $this->visit(route('admin-hotel.create'))
            ->type('hote2', '#username')
            ->type('123123', '#password')
            ->type('BluePrint', '#name')
            ->type('testAdminHotel@gmail.com', '#email')
            ->type('0987777666', '#phone')
            ->press('Create')
            ->see(trans('validation.min.string', [
                'attribute' => trans('messages.username'),
                'min' => 6,
            ]));
    }

    /**
     * Test if a hotel admin cant be created when issert username more than
     * 20 characters.
     */
    public function testCreateAdminHotelWithUsernameMoreThan20Characters()
    {
        $this->visit(route('admin-hotel.create'))
            ->type('hote22222222222222222222222222222222222222222', '#username')
            ->type('123123', '#password')
            ->type('BluePrint', '#name')
            ->type('testAdminHotel@gmail.com', '#email')
            ->type('0987777666', '#phone')
            ->press('Create')
            ->see(trans('validation.max.string', [
                'attribute' => trans('messages.username'),
                'max' => 20,
            ]));
    }

    /**
     * Test if a hotel admin cant be created when issert username with wrong regex.
     */
    public function testCreateAdminHotelWithWrongRegexUsername()
    {
        $this->visit(route('admin-hotel.create'))
            ->type('hotel admin2', '#username')
            ->type('123123', '#password')
            ->type('BluePrint', '#name')
            ->type('testAdminHotel@gmail.com', '#email')
            ->type('0987777666', '#phone')
            ->press('Create')
            ->see(trans('validation.regex', ['attribute' => trans('messages.username')]));
    }

    /**
     * Test if a hotel admin cant be created when issert password less
     * than 6 characters.
     */
    public function testCreateAdminHotelWithWrongRegexPassword()
    {
        $this->visit(route('admin-hotel.create'))
            ->type('hotel admin2', '#username')
            ->type('@@@@@@', '#password')
            ->type('BluePrint', '#name')
            ->type('testAdminHotel@gmail.com', '#email')
            ->type('0987777666', '#phone')
            ->press('Create')
            ->see(trans('validation.alpha_num', ['attribute' => trans('messages.password')]));
    }

    /**
     * Test if a hotel admin cant be created when issert username with wrong regex.
     */
    public function testCreateAdminHotelWithPasswordLessThan6Characters()
    {
        $this->visit(route('admin-hotel.create'))
            ->type('hotel admin2', '#username')
            ->type('abcde', '#password')
            ->type('BluePrint', '#name')
            ->type('testAdminHotel@gmail.com', '#email')
            ->type('0987777666', '#phone')
            ->press('Create')
            ->see(trans('validation.min.string', [
                 'attribute' => trans('messages.password'),
                 'min' => 6,
            ]));
    }

    /**
     * Test if a hotel admin cant be created when issert password more than
     * 20 characters.
     */
    public function testCreateAdminHotelWithPasswordMoreThan20Characters()
    {
        $this->visit(route('admin-hotel.create'))
            ->type('hotel admin2', '#username')
            ->type('abcde2222222222222222222222222', '#password')
            ->type('BluePrint', '#name')
            ->type('testAdminHotel@gmail.com', '#email')
            ->type('0987777666', '#phone')
            ->press('Create')
            ->see(trans('validation.max.string', [
            'attribute' => trans('messages.password'),
            'max' => 20,
            ]));
    }

    /**
     * Test if a hotel admin cant be created when issert name with a number.
     */
    public function testCreateAdminHotelWithNumericName()
    {
        $this->visit(route('admin-hotel.create'))
            ->type('hotel admin2', '#username')
            ->type('abcdef', '#password')
            ->type('212332', '#name')
            ->type('testAdminHotel@gmail.com', '#email')
            ->type('0987777666', '#phone')
            ->press('Create')
            ->see(trans('validation.regex', ['attribute' => trans('messages.name')]));
    }

    /**
     * Test if a hotel admin cant be created when issert phone with alpha
     * characters.
     */
    public function testCreateAdminHotelWithAlphaPhone()
    {
        $this->visit(route('admin-hotel.create'))
            ->type('hotel admin2', '#username')
            ->type('abcdef', '#password')
            ->type('BluePrint', '#name')
            ->type('testAdminHotel@gmail.com', '#email')
            ->type('abcdsdae', '#phone')
            ->press('Create')
            ->see(trans('validation.regex', ['attribute' => trans('messages.phone')]));
    }

    /**
     * Test if a hotel admin is edited.
     */
    public function testAdminHotelIsEdited()
    {
        //factory(HotelBooking\AdminHotel::class)->make();
        $faker = Faker\Factory::create();
        AdminHotel::create([
            'hotel_id' => 5,
            'username' => $faker->name,
            'name' => $faker->name,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
            'password' => str_random(10),
        ]);
        $adminHotel = AdminHotel::select('id')->first();
        $this->visit(route('admin-hotel.edit', $adminHotel->id))
             ->type('My Test Name', '#name')
             ->type('0906433992', '#phone')
             ->press('Update')
             ->see(trans('messages.edit_success_admin_hotel'))
             ->seeInDatabase('admin_hotels', ['name' => 'My Test Name']);
    }
}
