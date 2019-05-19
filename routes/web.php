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

Route::get('/', function () {
	    return view('front/home');
});


Auth::routes();

Route::get('/admin', 'Admin\LoginController@showLoginForm')->name('admin.login');

Route::post('/admin', 'Admin\LoginController@login');

Route::post('/logout-admin', 'Admin\LoginController@logout')->name('admin.logout');

/*
* Admin route
*/
Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin/dashboard', function () {
	    return view('back/content');
	})->name('dash.init');

	Route::get('/admin/dashboard/functionality', 'FunctionalityController')->name('dash.functionality');

	Route::get('/admin/dashboard/template', 'TemplateController')->name('dash.template');

	Route::get('/admin/dashboard/configuration', 'ConfigurationController')->name('dash.configuration');

	Route::post('/admin/dashboard/install-functionality', 'FunctionalityController@installFunctionality')->name('install.functionality');

	Route::post('/admin/dashboard/delete-functionality', 'FunctionalityController@deleteFunctionality')->name('delete.functionality');

	Route::post('/admin/dashboard/update-functionality', 'FunctionalityController@updateFunctionality')->name('update.functionality');

	Route::post('/admin/dashboard/install-template', 'TemplateController@installTemplate')->name('install.template');

	Route::post('/admin/dashboard/delete-template', 'TemplateController@deleteTemplate')->name('delete.template');

	Route::post('/admin/dashboard/update-template', 'TemplateController@updateTemplate')->name('update.template');

	/*
	* Functionalities Admin route
	*/
	Route::get('/admin/dashboard/users', 'AdminController')->name('dash.users');

	Route::post('/admin/dashboard/users-post', 'AdminController@formAdmin')->name('dash.users.post');

	Route::get('/admin/dashboard/permits-admin', 'AdminController@permits')->name('permits.admin');

	Route::get('/admin/dashboard/register-admin', 'AdminController@register')->name('register.admin');

	Route::post('/admin/dashboard/change-status', 'AdminController@changeState')->name('change.status');

	Route::post('/admin/dashboard/delete-admin', 'AdminController@deleteAdmin')->name('delete.admin');

	Route::get('/admin/dashboard/group', 'AdminController@group')->name('group.admin');

	Route::get('/admin/dashboard/group/configuration/{id}', 'AdminController@configurationGroup')->name('configuration.group');

	Route::post('/admin/dashboard/group/add', 'AdminController@addGroup')->name('add.group.admin');

	Route::get('/admin/dashboard/group/delete/{id}', 'AdminController@deleteGroup')->name('delete.group');

	/*
	* End Admin route
	*/

	// Editor routes 
	Route::get('/admin/editor', function () {
	    return view('back/selectEditor');
	})->name('select.editor');

	Route::post('/admin/editor/store/images', 'EditorController@builderStorageImage')->name('storage.images');

	Route::get('/admin/editor/{type}', 'EditorController@loadEditor')->name('select.type.editor');

	Route::post('/admin/editor/store/{page}', 'EditorController@builderPost');

	Route::get('/admin/editor/{page}/load', 'EditorController@builderLoad');

	// End editor routes 

	/*
	* Pages to Back-end route
	*/
	Route::get('admin/dashboard/pages', 'PageController')->name('dash.pages');

	Route::get('admin/dashboard/pages/add', 'PageController@showForm')->name('add.page');

	Route::post('admin/dashboard/pages/add/save', 'PageController@addPage')->name('add.page.action');

	Route::get('admin/dashboard/pages/edit/{page}', 'PageController@showForm')->name('edit.page');

	Route::post('admin/dashboard/pages/edit/save', 'PageController@editPage')->name('edit.page.action');

	Route::get('admin/dashboard/pages/delete/{page}', 'PageController@deletePage')->name('delete.page');



	Route::get('/page/{page}', 'PageController@loadFrontEnd')->name('view.page');

});


Route::get('/sign', function () {
    return view('front/sign');
});

