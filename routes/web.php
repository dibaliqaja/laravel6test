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
    return redirect()->route('majors.index');
});

Route::resource('majors', 'MajorController', ['except' => ['create', 'show']]);
Route::resource('students', 'StudentController', ['except' => 'show']);
Route::get('get-major', 'MajorController@getMajor')->name('getMajor');
