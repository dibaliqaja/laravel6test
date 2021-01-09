<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/mobile')->group(function () {
    Route::get('students', 'StudentController@getDataAllStudent')->name('get.all.student');
    Route::get('students/{id}', 'StudentController@getDataAllStudentWithFilter')->name('get.filter.student');
});
