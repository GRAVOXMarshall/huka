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

Route::get('/editor-prueba', function () {
	    return view('pruebas/index');
});

Route::get('/log', function () {
	    return view('front/sign');
});

Route::get('/reg', function () {
	    return view('front/signUp');
});

Auth::routes();

Route::get('/admin', 'Admin\LoginController@showLoginForm')->name('admin.login');

Route::post('/admin', 'Admin\LoginController@login');

Route::post('/logout-admin', 'Admin\LoginController@logout')->name('admin.logout');

/*
* Admin route
*/
Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin/dashboard', 'AdminController')->name('dash.init');

	Route::get('admin/dashboard/products/modules', 'ProductsController')->name('dash.products');

	Route::get('admin/dashboard/products/templates', 'ProductsController')->name('dash.products.templates');

	Route::get('/admin/dashboard/configuration', 'ConfigurationController')->name('dash.configuration');

	Route::post('/admin/dashboard/module/install', 'ProductsController@installProduct')->name('install.products');

	Route::post('/admin/dashboard/module/delete', 'ProductsController@deleteProduct')->name('delete.products');

	Route::post('/admin/dashboard/module/update', 'ProductsController@updateProduct')->name('update.products');

	Route::post('/admin/dashboard/template/install', 'ProductsController@installProduct')->name('install.products.template');

	Route::post('/admin/dashboard/template/delete', 'ProductsController@deleteProduct')->name('delete.products.template');

	Route::post('/admin/dashboard/template/update', 'ProductsController@updateProduct')->name('update.products.template');

	/*
	* Functionalities Admin route
	*/
	Route::get('/admin/dashboard/users', 'AdminController')->name('dash.users'); // Revisar esta ruta

	Route::get('/admin/dashboard/admin/add', 'AdminController@newAdmin')->name('dash.new.admin');

	Route::post('/admin/dashboard/admin/add/form', 'AdminController@addAdmin')->name('dash.add.admin');

	Route::post('/admin/dashboard/change-status', 'AdminController@changeState')->name('change.status');

	Route::post('/admin/dashboard/admin/delete', 'AdminController@deleteAdmin')->name('delete.admin');

	Route::post('/admin/dashboard/group/add', 'AdminController@addGroup')->name('add.group');

	Route::get('/admin/dashboard/group/delete/{id}', 'AdminController@deleteGroup')->name('delete.group');

	Route::post('/admin/dashboard/group/options', 'AdminController@options')->name('options.data');

	Route::post('/admin/dashboard/group/load/group', 'AdminController@loadGroup')->name('load.group'); 

	/*
	* End Admin route
	*/

	// Editor routes 
	Route::get('/admin/editor', function () {
	    return view('back/selectEditor');
	})->name('select.editor');

	// Editor routes 
	Route::get('/admin/test', 'EditorController@loadTest');

	Route::post('/admin/editor/store/images', 'EditorController@builderStorageImage')->name('storage.images');

	Route::get('/admin/editor/{type}', 'EditorController@loadEditor')->name('select.type.editor');

	Route::post('/admin/editor/store/{type}/{page}', 'EditorController@builderPost');

	Route::get('/admin/editor/load/{type}/{page}', 'EditorController@builderLoad');

	Route::post('/admin/editor/get/elements', 'EditorController@getElements')->name('get.elements');

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


	

	

	/*
	* Layouts to Back-end route
	*/
	Route::get('admin/dashboard/layouts', 'LayoutController')->name('dash.layouts');

	Route::get('admin/dashboard/layouts/add', 'LayoutController@showForm')->name('add.layout');

	Route::post('admin/dashboard/layouts/add/save', 'LayoutController@addLayout')->name('add.layout.action');

	Route::get('admin/dashboard/layouts/edit/{layout}', 'LayoutController@showForm')->name('edit.layout');

	Route::post('admin/dashboard/layouts/edit/save', 'LayoutController@editLayout')->name('edit.layout.action');

	Route::get('admin/dashboard/layouts/delete/{layout}', 'LayoutController@deleteLayout')->name('delete.layout');

	Route::get('admin/dashboard/layouts/edit/design/{layout}', 'LayoutController@loadEditor')->name('edit.layout.design');

	Route::post('admin/dashboard/layouts/edit/design/store/{layout}', 'LayoutController@builderLayout');
	
	Route::get('admin/dashboard/layouts/edit/design/{layout}/load', 'LayoutController@loadLayout');

});
/** 
Route for View a Page
**/
Route::get('/page/{page}/{value?}', 'PageController@loadFrontEnd')->name('view.page');


Route::get('/sign', function () {
    return view('front/sign');
});


/*
* Installer route
*/

Route::get('/install', 'InstallController@index');

Route::post('/install/terms', 'InstallController@agreeTerms')->name('agree.terms');

Route::get('/install/requirements', 'InstallController@requirements');

Route::get('/install/information', 'InstallController@information');

Route::post('/install/information', 'InstallController@setWebInformation')->name('set.information');

Route::get('/install/configuration', 'InstallController@configuration');

Route::post('/install/configuration', 'InstallController@setConfiguration')->name('set.configuration');

Route::get('/install/finish', 'InstallController@finish');

Route::post('/install/finish/configuration', 'InstallController@ajaxProcessSetConfiguration')->name('ajax.set.configuration');




