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
Route::group([ 'middleware' => 'auth', 'prefix' => 'ajax/', 'as' => 'ajax.' ], function(){
	Route::get('/fetch-id-permissions-for-profile/{id}', 'ProfileController@fetchIdPermissionsForProfile');
	Route::get('/fetch-id-permissions-for-role/{id}', 'RoleController@fetchIdPermissionsForRole');
	Route::post('/fetch-id-permissions-for-roles', 'RoleController@fetchIdPermissionsForRoles');
	Route::get('/fetch-id-roles-for-profile/{id}', 'ProfileController@fetchIdRolesForProfile');
	Route::get('/fetch-id-suppliers-for-item/{id}', 'ItemController@fetchIdSuppliersForItem');
	Route::get('/fetch-inventory-units', 'InventoryUnitController@fetchInventoryUnits')->name('fetch_inventory_units');
	Route::get('/fetch-items', 'ItemController@fetchItems')->name('fetch_items');
	Route::get('/fetch-item-brands', 'ItemBrandController@fetchItemBrands')->name('fetch_item_brands');
	Route::get('/fetch-item-groups', 'ItemGroupController@fetchItemGroups')->name('fetch_item_groups');
	Route::get('/fetch-profiles', 'ProfileController@fetchProfiles')->name('fetch_profiles');
	Route::get('/fetch-suppliers', 'SupplierController@fetchSuppliers')->name('fetch_suppliers');
	Route::post('/get-inventory-units', 'InventoryUnitController@anyData')->name('inventory_units.data');
	Route::post('/get-items', 'ItemController@anyData')->name('items.data');
	Route::post('/get-item-brands', 'ItemBrandController@anyData')->name('item_brands.data');
	Route::post('/get-item-bundlings', 'ItemBundlingController@anyData')->name('item_bundlings.data');
	Route::post('/get-item-groups', 'ItemGroupController@anyData')->name('item_groups.data');
	Route::post('/get-item-stocks', 'ItemStockController@anyData')->name('item_stocks.data');
	Route::post('/get-profiles', 'ProfileController@anyData')->name('profiles.data');
	Route::post('/get-roles', 'RoleController@anyData')->name('roles.data');
	Route::post('/get-suppliers', 'SupplierController@anyData')->name('suppliers.data');
	Route::post('/get-users', 'UserController@anyData')->name('users.data');
});
Route::group(['middleware' => 'auth'], function (){
	Route::resource('inventory-units', 'InventoryUnitController');
	Route::resource('items', 'ItemController');
	Route::resource('item-brands', 'ItemBrandController');
	Route::resource('item-bundlings', 'ItemBundlingController');
	Route::resource('item-groups', 'ItemGroupController');
	Route::resource('item-stocks', 'ItemStockController');
	Route::resource('profiles', 'ProfileController');
	Route::resource('roles', 'RoleController');
	Route::resource('suppliers', 'SupplierController');
	Route::resource('users', 'UserController');
});
