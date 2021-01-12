<?php
Auth::routes();
Route::get('/', function () {
    return redirect('/home');
})->middleware('auth');
if (config('app.env') == 'local') {
    Route::get('/tester', function () {
        $page_title = 'Tester';
        return view('pages.tester', compact('page_title'));
    })->middleware('auth');
}
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('profiles', 'ProfileController');
Route::resource('roles', 'RoleController');
Route::resource('users', 'UserController');
Route::group([ 'middleware' => 'auth', 'prefix' => 'ajax/', 'as' => 'ajax.' ], function(){
	Route::get('/fetch-item-groups', 'ItemGroupController@fetchItemGroups')->name('fetch_item_groups');
	Route::get('/get-permissions-from-a-role/{id}', 'RoleController@getPermissionsFromARole')->name('get_permissions_from_a_role');
	Route::post('/get-permissions-from-roles', 'RoleController@getPermissionsFromRoles')->name('get_permissions_from_roles');
	Route::post('/get-item-brands', 'ItemBrandController@anyData')->name('item_brands.data');
	Route::post('/get-item-groups', 'ItemGroupController@anyData')->name('item_groups.data');
	Route::post('/get-profiles', 'ProfileController@anyData')->name('profiles.data');
	Route::post('/get-roles', 'RoleController@anyData')->name('roles.data');
	Route::post('/get-suppliers', 'SupplierController@anyData')->name('suppliers.data');
	Route::post('/get-users', 'UserController@anyData')->name('users.data');
});
Route::group(['middleware' => 'auth'], function (){
	Route::resource('item-brands', 'ItemBrandController');
	Route::resource('item-groups', 'ItemGroupController');
	Route::resource('suppliers', 'SupplierController');
});
