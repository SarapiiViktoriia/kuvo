<?php
use Illuminate\Http\Request;
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['as' => 'api.'], function(){
	Route::apiResource('item-brands', 'Api\ApiItemBrandController');
	Route::apiResource('item-groups', 'Api\ApiItemGroupController');
	Route::apiResource('suppliers', 'Api\ApiSupplierController');
});
