<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use HotelBooking\User;
use HotelBooking\AdminUser;

class UserFormTest extends TestCase
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
     * Create User
     *
     * @return HotelBooking\User
     */
    public function createUser()
    {
        $faker = Faker\Factory::create();
        $roomType = User::create([
            'name' => $faker->name,
            'username' => $faker->username,
            'password' => $faker->password,
            'email' => $faker->email,
            'phone' => "0".rand(100000000, 99999999999),
            'address' => $faker->address,
        ]);

        return $roomType;
    }

    /**
     * Test Index User
     *
     * @return void
     */
    function testIndexUser()
    {
        $this->visit(route('admin.user.index'))
            ->see(trans('messages.user'));
    }

    /**
     * Test Edit user
     *
     * @return void
     */
    function testEditUser()
    {
        $user = $this->createUser();
        $this->visit(route('admin.user.edit', $user->id))
            ->see(trans('messages.edit_user'))
            ->dontsee(trans('messages.data_not_found'));
    }

    /**
     * Test Put Update User
     *
     * @return void
     */
    function testPutUpdateUser()
    {
        $faker = Faker\Factory::create();
        $user = $this->createUser();
        $name = $faker->name;
        $this->visit(route('admin.user.edit', $user->id))
            ->type($name, 'name')
            ->type("0".rand(100000000, 99999999999), 'phone')
            ->type($faker->address, 'address')
            ->press(trans('messages.update'))
            ->see(trans('messages.update_success'))
            ->seeIndatabase('users', ['name' => $name])
            ->dontsee('has-error');
    }

    /**
     * Test Delete User
     *
     * @return void
     */
    function testDeleteUser()
    {
        $user = $this->createUser();
        $this->visit(route('admin.user.index'))
        ->press(trans('messages.delete'))
        ->see(trans('messages.delete_success'));
    }
}
