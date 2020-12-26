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
