<?php
$ADMIN_PREFIX = "admin";
Route::model('user', 'App\Models\User');

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

Route::get('clear-cache', function () {
	$exitCode = Artisan::call('cache:clear');
	$exitCode = Artisan::call('view:clear');
	$exitCode = Artisan::call('route:clear');
	$exitCode = Artisan::call('config:clear');
	$exitCode = Artisan::call('debugbar:clear');
	return ["status" => 1, "msg" => "Cache cleared successfully!"];
});

/***************    Admin routes  **********************************/
Route::group(['prefix' => $ADMIN_PREFIX], function(){
    
    Route::get('/', 'admin\AdminLoginController@getLogin')->name("admin_login");
    Route::get('login', 'admin\AdminLoginController@getLogin')->name("admin_login");
    Route::post('login', 'admin\AdminLoginController@postLogin')->name("check_admin_login");
    
    Route::group(['middleware' => 'admin_auth'], function(){

//dashboard
    Route::get('logout', 'admin\AdminLoginController@getLogout')->name("admin_logout");
    Route::get('dashboard', 'admin\AdminController@index')->name("admin_dashboard");

    Route::get('change-password', 'admin\AdminController@changePassword')->name("admin_change_password");
    Route::post('change-password', 'admin\AdminController@postChangePassword')->name("admin_update_password");

    Route::get('profile', 'admin\AdminController@editProfile')->name("admin_edit_profile");
    Route::post('profile', 'admin\AdminController@updateProfile')->name("admin_update_profile");
        
//Admin Users
    Route::any('admin-userlogs/data', 'admin\AdminUserLogsController@data')->name('admin-userlogs.data');
	Route::resource('admin-userlogs', 'admin\AdminUserLogsController');

	Route::any('admin-users/data', 'admin\AdminUserController@data')->name('admin-users.data');
	Route::resource('admin-users', 'admin\AdminUserController'); 

	Route::any('admin-user-types/data', 'admin\AdminUserTypeController@data')->name('admin-user-types.data');
 	Route::resource('admin-user-types', 'admin\AdminUserTypeController');

//Frontend Users
	Route::any('users/data', 'admin\UsersController@data')->name('users.data');
 	Route::resource('users', 'admin\UsersController');

 	Route::any('user-types/data', 'admin\UserTypesController@data')->name('user-types.data');
 	Route::resource('user-types', 'admin\UserTypesController');

//vendors
 	Route::any('vendor-categories/data', 'admin\VendorCategoriesController@data')->name('vendor-categories.data');
 	Route::resource('vendor-categories', 'admin\VendorCategoriesController');

	Route::any('vendors/change-status/{id}/{status}', 'admin\VendorsController@changeStatus');
	Route::any('vendors/view', 'admin\VendorsController@viewData');
	Route::any('vendors/data', 'admin\VendorsController@data')->name('vendors.data');
 	Route::resource('vendors', 'admin\VendorsController');  	

//Masters	
	Route::any('admin-actions/data', 'admin\AdminActionController@data')->name('admin-actions.data');
	Route::resource('admin-actions', 'admin\AdminActionController'); 

//User Action
	Route::any('user-actions/data', 'admin\UserActionController@data')->name('user-actions.data');
	Route::resource('user-actions', 'admin\UserActionController'); 

//Countries
	Route::any('countries/data', 'admin\CountriesController@data')->name('countries.data');
	Route::resource('countries', 'admin\CountriesController'); 

//States
	Route::any('states/data', 'admin\StatesController@data')->name('states.data');
	Route::resource('states', 'admin\StatesController'); 
        
//Cities        
	Route::any('cities/data', 'admin\CitiesController@data')->name('cities.data');
	Route::resource('cities', 'admin\CitiesController');        
	Route::any('cities/getstates', 'admin\CitiesController@getstates')->name('getstates');
	Route::any('cities/getcities', 'admin\CitiesController@getcities')->name('getcities');
    
//Users Permissions
	Route::get('user-type-rights', 'admin\AdminController@rights')->name("list-assign-rights");
	Route::post('user-type-rights', 'admin\AdminController@rights')->name("assign-rights");        
	Route::any('modules/data', 'admin\AdminModulesController@data')->name('modules.data');
	Route::resource('modules', 'admin\AdminModulesController');

//Admin Module        
	Route::any('module-pages/data', 'admin\AdminModulePagesController@data')->name('module-pages.data');
	Route::resource('module-pages', 'admin\AdminModulePagesController');

//Portfolio  
 	Route::get('portfolio/data', 'admin\PortfolioController@data')->name('portfolio.data');
    Route::resource('portfolio', 'admin\PortfolioController');

//PortfolioCategory 
    Route::get('portfoliocategory/data', 'admin\PortfolioCategoriesController@data')->name('portfoliocategory.data');
    Route::resource('portfoliocategory', 'admin\PortfolioCategoriesController');

    });   

//Packge
	Route::get('package/data', 'admin\PackageController@data')->name('package.data');
    Route::resource('package', 'admin\PackageController');

 //PackageCategory
 	Route::get('package-category/data', 'admin\PackageCategoryController@data')->name('package-category.data');
    Route::resource('package-category', 'admin\PackageCategoryController');

//Blog Category
	Route::any('blog/categories/data', 'admin\BlogCategoryController@data')->name("blog.categories.data");
	Route::resource('blog/categories', 'admin\BlogCategoryController', ['as' => 'blog']);

//Blog Tage
    Route::any('blog/tags/data', 'admin\BlogTagsController@data')->name("blog.tags.data");
	Route::resource('blog/tags', 'admin\BlogTagsController', ['as' => 'blog']);

//Blog Post	
	Route::any('blog/posts/data', 'admin\BlogPostsController@data')->name("blog.posts.data");
	Route::resource('blog/posts', 'admin\BlogPostsController', ['as' => 'blog']);
 	
 
});
