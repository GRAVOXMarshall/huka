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

Route::prefix('authentication')->group(function() {
	Route::get('/', 'ConfiguratesController@displayConfigurations');

	Route::post('/validator/ajax', 'ConfiguratesController@processAjaxValidator')->name('authentication.ajax.validator');

	Route::post('/configuration/database', 'ConfiguratesController@processConfigurationDataBase')->name('configuration.database');

	Route::post('/configuration/type/login', 'ConfiguratesController@processConfigurationTypeLogin')->name('configuration.type.login');

	Route::post('/configuration/ajax/getconfig', 'ConfiguratesController@processAjaxGetConfigurations')->name('authentication.ajax.configurations');

	Route::post('/configuration/page', 'ConfiguratesController@processConfigurationPage')->name('configuration.page');

	Route::post('/validator/ajax/getpage', 'ConfiguratesController@processAjaxLoginPage')->name('authentication.ajax.loginPage');

	Route::post('/configuration/design/login', 'ConfiguratesController@processConfigurationDesignLogin')->name('configuration.design.login');
	
	Route::post('/login', 'AuthenticationController@login')->name('authentication.login');

});
