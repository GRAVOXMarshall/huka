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

Route::prefix('module/contact')->group(function() {
    Route::get('/', 'ConfiguratesController@displayConfigurations')->name('contact.configuration');
    
    Route::post('/configuration/page', 'ConfiguratesController@processConfigurationPage')->name('contact.configuration.page');

	Route::post('/configuration/design', 'ConfiguratesController@processConfigurationDesignLogin')->name('contact.configuration.design');

	Route::post('/configuration/design/test', 'ConfiguratesController@test')->name('contact.configuration.test');

	Route::post('/send/contact', 'ContactController@sendMails')->name('contact.send.mail');
});
