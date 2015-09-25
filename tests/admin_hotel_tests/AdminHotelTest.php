<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminHotelTest extends TestCase
{

	use DatabaseTransactions;
	
    /**
     * A basic test example.
     *
     * @return void
     */
    
    //Test if can get correct hotel admin create page.
  	public function testCreate()
  	{
  		$response=$this->call('GET', route('admin-hotel.create'));
  		$this->assertResponseOk();
  	}

  	//Test if can get redirect when post a hotel admin create form
  	public function testStore()
  	{
  		$this->WithoutMiddleware();
  		$this->call('POST', route('admin-hotel.create'));
  		$this->assertResponseStatus(302);
  	}

  	//Test if can get correct  hotel admin edit page.
  	public function testEdit()
  	{
  		$response=$this->call('GET', route('admin-hotel.edit', 1));	
  		$this->assertResponseOk();
  		$this->assertViewHas('adminHotel');
  	}

  	//Test if can get redirect when put a hotel admin edit form to update data
  	public function testUpdate()
  	{
  		$this->WithoutMiddleware();
  		$this->call('PUT', route('admin-hotel.update',1));
  		$this->assertResponseStatus(302);
  	}

  	//Test if an hotel admin is created when issert valid data
    public function testNewAdminHotelCreated()
    {
    	$this->visit(route('admin-hotel.create'))
    		 ->type('hoteladmin892', '#username')
    		 ->type('123456', '#password')
    		 ->type('Justin Beiber', '#name')
    		 ->type('testAdminHotel@gmail.com', '#email')
    		 ->type('0987666223', '#phone')
    		 ->press('Submit')
    		 //->assertRedirectedTo(route('admin-hotel.create'));
    		 ->see('You had created an admin hotel account');

    }

    //Test if an hotel admin cant be created when issert null username
    public function testCreateAdminHotelWithoutUsername()
    {
    	$this->visit(route('admin-hotel.create'))
    		 ->type('', '#username')
    		 ->type('123456', '#password')
    		 ->type('Justin Beiber', '#name')
    		 ->type('testAdminHotel@gmail.com', '#email')
    		 ->type('0987666223', '#phone')
    		 ->press('Submit')
    		 ->see('The username field is required.');
    }
}
