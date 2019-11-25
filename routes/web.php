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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'UserController@showUsers')->middleware('auth');
Route::get('/user/add', function() {return view('useradd');})->middleware('auth');
Route::post('/user/add', 'UserController@add')->middleware('auth');
Route::get('/user/{id}/edit', 'UserController@edit')->middleware('auth');
Route::post('/user/{id}/store', 'UserController@store')->middleware('auth');

Route::get('/disciplines', function() {return view('disciplines');})->middleware('auth');
Route::get('/discipline/add', function() {return view('disciplineadd');})->middleware('auth');
Route::get('/discipline/{id}/edit', 'DisciplineController@edit')->middleware('auth');
Route::post('/discipline/add', 'DisciplineController@add')->middleware('auth');
Route::post('/discipline/{id}/store', 'DisciplineController@store')->middleware('auth');