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

Route::prefix('module/useraccount')->group(function() {
    Route::get('/', 'ConfiguratesController@displayConfigurations')->name('useraccount.configuration');

    Route::post('/configuration/variables', 'ConfiguratesController@processConfigurationVariables')->name('useraccount.configuration.variables');
    
    Route::post('/configuration/page', 'ConfiguratesController@processConfigurationPage')->name('useraccount.configuration.page');

	Route::post('/configuration/design/login', 'ConfiguratesController@processConfigurationDesignLogin')->name('useraccount.configuration.design');
	
});
