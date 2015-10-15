<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;

/**
 * Test class for user auth controller
 */
class UserAuthControllerTest extends TestCase
{

    use DatabaseTransactions;
    /**
     * Override setUp function before running tests
     */
    public function setUp()
    {
        parent::setUp();
        static $seed = false;
        if (!$seed) {
            DB::table('users')->truncate();
            $this->seed('UserTableSeeder');
            $seed = true;
        }
    }

    /**
     * Test the status of postLogin
     */
    public function testPostLoginStatus()
    {
        $this->withoutMiddleware();
        $response = $this->call('POST', route('user.login'));
        $this->assertEquals(302, $response->status());
    }

    /**
     * Test Login success fully by assert json
     */
    public function testPassLogin()
    {
        $this->withoutMiddleware();
        $formParams = [
            'username' => 'user01',
            'password' => '123123',
            'pathname' => route('user.index')
        ];
        $this->post(route('user.login'), $formParams)
            ->seeJson([
                'status' => 'success',
            ]);
    }

    /**
     * Test login failed with wrong rules username and password
     */
    public function testWrongFormatFields()
    {
        $this->withoutMiddleware();
        $formParams = [
            'username' => '',
            'password' => '',
            'pathname' => (route('user.index')),
        ];
        $this->post(route('user.login'), $formParams)
            ->assertResponseStatus(302);
    }

    /**
     * Test user cant login with incorrect account
     */
    public function testLoginFail()
    {
        $this->withoutMiddleware();
        $formParams = [
            'username' => 'wronguser',
            'password' => 'wrongpass',
            'pathname' => route('user.index')
        ];
        $this->post(route('user.login'), $formParams)
            ->assertSessionHas('flash_error', trans('messages.login_fail'));
    }
}
