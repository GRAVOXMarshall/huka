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

Route::prefix('module/authentication')->group(function() {
	Route::get('/', 'ConfiguratesController@displayConfigurations')->name('authentication.configuration');

	Route::post('/configuration/database', 'ConfiguratesController@processConfigurationDataBase')->name('authentication.configuration.database');

	Route::post('/configuration/type/login', 'ConfiguratesController@processConfigurationTypeLogin')->name('authentication.configuration.type.login');

	Route::post('/configuration/page', 'ConfiguratesController@processConfigurationPage')->name('authentication.configuration.page');

	Route::post('/configuration/design/login', 'ConfiguratesController@processConfigurationDesignLogin')->name('authentication.configuration.design');
	
	Route::post('/login', 'AuthenticationController@login')->name('authentication.login');

	Route::post('/logout', 'AuthenticationController@logout')->name('authentication.logout');

	Route::post('/register', 'AuthenticationController@register')->name('authentication.register');

});
