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
            ->seeJson([
                'status' => 'failed'
            ]);
    }

    /**
     * Test the status when request register form
     */
    public function testRegisterStatus()
    {
        $this->call('GET', route('user.register'));
        $this->assertResponseOk();
    }

    /**
     * Test the status when request post register form;
     */
    public function testRegisterPostStatus()
    {
        $this->withOutMiddleWare();
        $this->call('POST', route('user.register'));
        $this->assertResponseStatus(302);
    }

    /**
     * Test Can not Register will null fields
     */
    public function testCantRegisterWithNullFields()
    {
        $this->visit(route('user.register'))
            ->press(trans('messages.register'))
            ->see(trans('validation.required', [
                'attribute' => 'username'
            ]))
            ->see(trans('validation.required', [
                'attribute' => 'password'
            ]))
            ->see(trans('validation.required', [
                'attribute' => 'name'
            ]))
            ->see(trans('validation.required', [
                'attribute' => 'phone'
            ]))
            ->see(trans('validation.required', [
                'attribute' => 'email'
            ]));
    }

    /**
     * Test can not register with a username already exists
     */
    public function testUniqueUsername()
    {
        $this->visit(route('user.register'))
            ->type('user01', '#username')
            ->press(trans('messages.register'))
            ->see(trans('validation.unique', [
                'attribute' => 'username'
            ]));
    }

    /**
     * Test can not register with password and password retype are not the same
     */
    public function testPasswordRetypeNotCorrect()
    {
        $this->visit(route('user.register'))
            ->type('password', '#password')
            ->type('wrongretype', '#retype_password')
            ->press(trans('messages.register'))
            ->see(trans('validation.same', [
                'attribute' => 'retype password',
                'other' => 'password'
            ]));
    }

    /**
     * Test can not register with wrong email format
     */
    public function testWrongEmailFormat()
    {
        $this->visit(route('user.register'))
            ->type('notaneamil', '#email')
            ->press(trans('messages.register'))
            ->see(trans('validation.email', [
                'attribute' => 'email',
            ]));
    }

    /**
     * Test can not register with phone is not a number
     */
    public function testPhoneIsNotANumber()
    {
        $this->visit(route('user.register'))
            ->type('not a number', '#phone')
            ->press(trans('messages.register'))
            ->see(trans('validation.regex', [
                'attribute' => 'phone',
            ]));
    }

    /**
     * Test can not register with phone field less than 10 characters
     */
    public function testPhoneIsLessThan10Characters()
    {
        $this->visit(route('user.register'))
            ->type('098877766', '#phone')
            ->press(trans('messages.register'))
            ->see(trans('validation.min.string', [
                'attribute' => 'phone',
                'min' => 10
            ]));
    }

    /**
     * Test can not register with phone field more than 15 characters
     */
    public function testPhoneIsMoreThan15Characters()
    {
        $this->visit(route('user.register'))
            ->type('0988777669999222', '#phone')
            ->press(trans('messages.register'))
            ->see(trans('validation.max.string', [
                'attribute' => 'phone',
                'max' => 15
            ]));
    }

    /**
     * Test Register success
     */
    public function testRegisterSuccess()
    {
        $this->visit(route('user.register'))
            ->type('username', '#username')
            ->type('password', '#password')
            ->type('password', '#retype_password')
            ->type('email@gmail.com', '#email')
            ->type('John Mark', '#name')
            ->type('0988777666', '#phone')
            ->press(trans('messages.register'))
            ->see(trans('messages.register_success'))
            ->seeInDataBase('users', [
                'username' => 'username',
                'email' => 'email@gmail.com'
            ]);
    }
}
