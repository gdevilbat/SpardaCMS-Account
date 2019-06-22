<?php

namespace Gdevilbat\SpardaCMS\Modules\Account\Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountTest extends DuskTestCase
{
    use DatabaseMigrations, \Gdevilbat\SpardaCMS\Modules\Core\Tests\ManualRegisterProvider;
    
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testEditProfile()
    {
        $user = \Gdevilbat\SpardaCMS\Modules\Core\Entities\User::with('userAccount')->find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $faker = \Faker\Factory::create();

            $browser->loginAs($user)
                    ->visit(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
                    ->assertSee('Account')
                    ->type('email', empty($user->email) ? $faker->unique()->safeEmail : $user->email)
                    ->type('name', empty($user->name) ? $faker->name : $user->name)
                    ->type('phone_number', empty($user->userAccount->phoneNumber) ? $faker->phoneNumber : $user->userAccount->phoneNumber)
                    ->type('address', empty($user->address) ? $faker->address : $user->address);

            $birthday = empty($user->userAccount->birthday) ? "1993-12-12" : $user->userAccount->birthday;

            $browser->script('document.getElementsByName("gender")[0].checked = true');
            $browser->script('document.getElementsByName("birthday")[0].value = "'.$birthday.'"');

            $browser->press('Save changes')
                    ->waitForText('Account')
                    ->assertSee('Successfully Update Profile!');
        });
    }

    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testUpdatePassword()
    {
        $user = \Gdevilbat\SpardaCMS\Modules\Core\Entities\User::with('userAccount')->find(1);

        $this->browse(function (Browser $browser) use ($user) {
            $faker = \Faker\Factory::create();

            $browser->loginAs($user)
                    ->visit(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
                    ->assertSee('Account')
                    ->click('[href="#m_user_profile_tab_3"]')
                    ->type('old_password', 'smartnaco')
                    ->type('password', 'anabadabinlove')
                    ->type('password_confirmation', 'anabadabinlove')
                    ->press('Save changes')
                    ->waitForText('Account')
                    ->assertSee('Successfully Change Password!');
        });
    }
}
