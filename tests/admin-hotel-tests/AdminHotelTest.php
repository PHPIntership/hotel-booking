<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\AdminHotel;

class AdminHotelTest extends TestCase
{

	use DatabaseTransactions;
	
    /**
     * A basic test example.
     *
     * @return void
     */
    
    /**
     * Test if can get correct hotel admin create page status.
     * @return void
     */
  	public function testCreateStatus()
  	{
  	    $response = $this->call('GET', route('admin-hotel.create'));
  	    $this->assertResponseOk();
  	}

  	/**
     *Test if can get correct hotel admin store page status. 
     * @return void
     */
  	public function testStoreStatus()
  	{
  	    $this->WithoutMiddleware();
  	    $this->call('POST', route('admin-hotel.store'));
  	    $this->assertResponseStatus(302);
  	}

  	/**
     *Test if can get correct  hotel admin edit page status. 
     * @return void
     */
  	public function testEditStatus()
  	{
        $faker = Faker\Factory::create();
        AdminHotel::create([
            'hotel_id'=>rand(0,10),
            'username'=>$faker->name,
            'name' => $faker->name,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
            'password' => bcrypt(str_random(10)),
        ]);
        $adminHotel = AdminHotel::select('id')->first();
	    $response = $this->call('GET', route('admin-hotel.edit', $adminHotel->id));	
	    $this->assertResponseOk();
	    $this->assertViewHas('adminHotel');
  	}

  	/**
     *Test if can get correct  hotel admin update page status 
     * @return void
     */
  	public function testUpdateStatus()
  	{
        $this->WithoutMiddleware();
        $this->call('PUT', route('admin-hotel.update', 1));
        $this->assertResponseStatus(302);
  	}

  	/**
     *Test if a hotel admin is created when issert valid data 
     * @return void
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
    		 ->see(trans('messages.create_success'));
    }

    /**
     * Test if a hotel admin cant be created when issert null username
     * @return void
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
    		 ->see('The username field is required.');
    }
    /**
     * Test if a hotel admin cant be created when issert null password
     * @return void
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
         ->see('The password field is required.');
    }
    /**
     * Test if a hotel admin cant be created when issert null name
     * @return void
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
         ->see('The name field is required.');
    }
    /**
     * Test if a hotel admin cant be created when issert null email
     * @return void
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
         ->see('The email field is required.');
    }
    /**
     * Test if a hotel admin cant be created when issert null phone
     * @return void
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
         ->see('The phone field is required.');
    }
    /**
     * Test if a hotel admin cant be created when issert username less
     * than 6 characters
     * @return [type] [description]
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
         ->see('The username must be at least 6 characters.');
    }
    /**
     * Test if a hotel admin cant be created when issert username more than
     * 20 characters
     * @return void
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
         ->see('The username may not be greater than 20 characters.');
    }
    /**
     * Test if a hotel admin cant be created when issert username with wrong regex
     * @return void
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
         ->see('The username format is invalid.'); 
    }
    /**
     * Test if a hotel admin cant be created when issert password less
     * than 6 characters
     * @return void
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
         ->see('The password may only contain letters and numbers.');
    }
    /**
     * Test if a hotel admin cant be created when issert username with wrong regex
     * @return void
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
         ->see('The password must be at least 6 characters.');
    }
    /**
     * Test if a hotel admin cant be created when issert password more than
     * 20 characters
     * @return void
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
         ->see('The password may not be greater than 20 characters.');
    }
    /**
     * Test if a hotel admin cant be created when issert name with a number
     * @return void
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
         ->see('The name format is invalid.');
    }
    /**
     * Test if a hotel admin cant be created when issert phone with alpha
     * characters
     * @return void
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
         ->see('The phone format is invalid.');
    }
    /**
     * Test if a hotel admin is edited
     * @return [type] [description]
     */
    public function testAdminHotelIsEdited()
    {
        //factory(HotelBooking\AdminHotel::class)->make();
        $faker = Faker\Factory::create();
        AdminHotel::create([
            'hotel_id'=>5,
            'username'=>$faker->name,
            'name' => $faker->name,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
            'password' => bcrypt(str_random(10)),
        ]);
        $adminHotel = AdminHotel::select('id')->first();
        $this->visit(route('admin-hotel.edit', $adminHotel->id))
             ->type('My Test Name', '#name')
             ->type('0906433992', '#phone')
             ->press('Update')
             ->see('Successfully updated information')
             ->seeInDatabase('admin_hotels', ['name'=>'My Test Name']);
    }



    
}
