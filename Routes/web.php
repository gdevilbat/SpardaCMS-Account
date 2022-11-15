<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'control', 'middleware' => 'core.menu'], function() {
    
	Route::group(['middleware' => 'core.auth'], function() {

		Route::group(['prefix' => 'account'], function() {

			Route::post('me', 'AccountController@me')->name('account');

	        /*=============================================
	        =            Account CMS            =
	        =============================================*/
	        
			    Route::get('profile', 'AccountController@index')->name('account');
			    Route::put('update-profile', 'AccountController@personal')->name('account');
			    Route::put('update-avatar', 'AccountController@avatar')->name('account');
			    Route::put('update-password', 'AccountController@password')->name('account');
	        
	        /*=====  End of Account CMS  ======*/
		});
        
	});
});
