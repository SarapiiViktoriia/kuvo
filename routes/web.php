<?php
Auth::routes();
Route::get('/', function () {
    return redirect('/home');
})->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home');
