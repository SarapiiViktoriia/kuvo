<?php
use Illuminate\Http\Request;
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['as' => 'api.'], function(){
	Route::apiResource('companies', 'Api\ApiCompanyController');
	Route::apiResource('items', 'Api\ApiItemController');
	Route::apiResource('item-brands', 'Api\ApiItemBrandController');
	Route::apiResource('item-groups', 'Api\ApiItemGroupController');
	Route::apiResource('purchases', 'Api\ApiPurchaseController');
	Route::apiResource('suppliers', 'Api\ApiSupplierController');
});
