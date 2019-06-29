<?php

namespace Gdevilbat\SpardaCMS\Modules\Account\Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Storage;

class AccountControllerTest extends TestCase
{
	use RefreshDatabase, \Gdevilbat\SpardaCMS\Modules\Core\Tests\ManualRegisterProvider;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testShowProfile()
    {
   		$this->get(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
        	 ->assertStatus(302)
    		 ->assertRedirect(action('\Gdevilbat\SpardaCMS\Modules\Core\Http\Controllers\Auth\LoginController@showLoginForm')); // Return Not Valid, User Not Login
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testUpdateProfile()
    {
        $this->from(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
             ->post(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@personal', [
             	'_method' => 'PUT'
             ]))
	         ->assertStatus(302)
    		 ->assertRedirect(action('\Gdevilbat\SpardaCMS\Modules\Core\Http\Controllers\Auth\LoginController@showLoginForm')); // Return Not Valid, User Not Login

		$user = \App\User::find(1);

		$this->actingAs($user)
        				 ->from(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
        				 ->post(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@personal', [
			             	'_method' => 'PUT'
			             ]))
        				 ->assertStatus(302)
        				 ->assertRedirect(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
        				 ->assertSessionHasErrors(); //Return Not Valid, Data Not Complete

		$faker = \Faker\Factory::create();
		$this->actingAs($user)
        				 ->from(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
        				 ->post(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@personal', [
        				 	'email' => $user->email,
        				 	'name' => $user->name,
        				 	'gender' => 'gender',
        				 	'birthday' => '1993-12-12',
        				 	'phone_number' => $faker->phoneNumber,
        				 	'address' => $faker->address,
			             	'_method' => 'PUT'
			             ]))
        				 ->assertStatus(302)
        				 ->assertRedirect(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
        				 ->assertSessionHasNoErrors()
        				 ->assertSessionHas('global_message.status', 200); //Return Valid, Data Complete
    }

    public function testUpdatePassword()
    {
    	$this->from(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
             ->post(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@password', [
             	'_method' => 'PUT'
             ]))
	         ->assertStatus(302)
    		 ->assertRedirect(action('\Gdevilbat\SpardaCMS\Modules\Core\Http\Controllers\Auth\LoginController@showLoginForm')); // Return Not Valid, User Not Login

		$user = \App\User::find(1);

		$this->actingAs($user)
        				 ->from(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
        				 ->post(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@password', [
			             	'_method' => 'PUT'
			             ]))
        				 ->assertStatus(302)
        				 ->assertRedirect(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
        				 ->assertSessionHasErrors(); //Return Not Valid, Data Not Complete

        $faker = \Faker\Factory::create();
        $password = $faker->name;
		$this->actingAs($user)
        				 ->from(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
        				 ->post(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@password', [
        				 	'old_password' => 'smartnaco',
        				 	'password' => $password,
        				 	'password_confirmation' => $password,
			             	'_method' => 'PUT'
			             ]))
        				 ->assertStatus(302)
        				 ->assertRedirect(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
        				 ->assertSessionHasNoErrors()
        				 ->assertSessionHas('global_message.status', 200); //Return Valid, Data Complete
    }

    public function testUpdateAvatar()
    {
    	$this->from(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
             ->post(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@avatar', [
             	'_method' => 'PUT'
             ]))
	         ->assertStatus(302)
    		 ->assertRedirect(action('\Gdevilbat\SpardaCMS\Modules\Core\Http\Controllers\Auth\LoginController@showLoginForm')); // Return Not Valid, User Not Login

		$user = \Gdevilbat\SpardaCMS\Modules\Core\Entities\User::with('userAccount')->find(1);

		$this->actingAs($user)
        				 ->from(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
        				 ->post(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@avatar', [
			             	'_method' => 'PUT'
			             ]))
        				 ->assertStatus(302)
        				 ->assertRedirect(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
        				 ->assertSessionHas('global_message.status', 400); //Return Not Valid, Data Not Complete

        Storage::fake('public');

        $file = \Illuminate\Http\UploadedFile::fake()->image('avatar.jpg')->size(100);

		$this->actingAs($user)
        				 ->from(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
        				 ->json('POST',action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@avatar', [
        				 	'profile_image_url' => $file,
			             	'_method' => 'PUT',
			             ]))
        				 ->assertStatus(302)
        				 ->assertRedirect(action('\Gdevilbat\SpardaCMS\Modules\Account\Http\Controllers\AccountController@index'))
        				 ->assertSessionHasNoErrors();
        
        //Storage::disk('public')->assertExists($file->hashName());
    }
}
