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

Route::prefix('control')->group(function() {
});

Route::group(['prefix' => 'control'], function() {
    
	Route::group(['middleware' => 'core.auth'], function() {

		Route::group(['prefix' => 'account'], function() {
	        /*=============================================
	        =            Account CMS            =
	        =============================================*/
	        
			    Route::get('profile', 'AccountController@index');
			    Route::put('update-profile', 'AccountController@personal');
			    Route::put('update-avatar', 'AccountController@avatar');
			    Route::put('update-password', 'AccountController@password');
	        
	        /*=====  End of Account CMS  ======*/
		});
        
	});
});
