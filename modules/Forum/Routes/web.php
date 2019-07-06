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

    Route::post('/configuration/database', 'ConfiguratesController@processConfigurationDataBase')->name('forum.configuration.database');
    
    Route::post('/configuration/page', 'ConfiguratesController@processConfigurationPage')->name('forum.configuration.page');

	Route::post('/configuration/design', 'ConfiguratesController@processConfigurationDesign')->name('forum.configuration.design');

	Route::post('/forum/add/topic', 'ForumController@submitAddTopic')->name('forum.add.topic');

	Route::post('/create/comments', 'ConfiguratesController@createComments')->name('create.comments');
});
