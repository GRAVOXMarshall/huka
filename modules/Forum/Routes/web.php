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

Route::prefix('module/forum')->group(function() {
    Route::get('/', 'ConfiguratesController@displayConfigurations')->name('forum.configuration');
    
    Route::post('/configuration/page', 'ConfiguratesController@processConfigurationPage')->name('forum.configuration.page');

	Route::post('/configuration/design', 'ConfiguratesController@processConfigurationDesignLogin')->name('forum.configuration.design');

	Route::post('/configuration/testing', 'ConfiguratesController@testing')->name('forum.configuration.testing');
});
