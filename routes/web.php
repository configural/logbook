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


// Управление списком дисциплин
Route::get('/disciplines', function() {return view('disciplines');})->middleware('auth');
Route::get('/discipline/{id}', 'DisciplineController@view')->middleware('auth');
Route::get('/disciplines/add', function() {return view('disciplineadd');})->middleware('auth');
Route::get('/disciplines/{id}/edit', 'DisciplineController@edit')->middleware('auth');
Route::post('/disciplines/add', 'DisciplineController@add')->middleware('auth');
Route::post('/disciplines/{id}/store', 'DisciplineController@store')->middleware('auth');

// Управление списком тематических блоков внутри дисциплин
Route::get('/block/add/{id}', function($id) {return view('blockadd', ['id'=>$id]);})->middleware('auth');
Route::get('/block/{id}/edit', 'BlockController@edit')->middleware('auth');
Route::post('/block/add', 'BlockController@add')->middleware('auth');
Route::post('/block/{id}/store', 'BlockController@store')->middleware('auth');
//Route::post('/block/{id}/delete', 'BlockController@delete')->middleware('auth');

// Управление списком дополнительных образовательных программ 
Route::get('/programs', function(){ return view('programs');})->middleware('auth');
Route::get('/program/add', function(){ return view('programadd');})->middleware('auth');
Route::post('/program/add', 'ProgramController@add')->middleware('auth');
Route::get('/program/{id}', function($id){ return view('program', ['id' => $id]);})->middleware('auth');
Route::post('/program/{id}/store', 'ProgramController@store')->middleware('auth');
Route::get('/program/{id}/edit', function($id){ return view('programedit', ['id' => $id]);})->middleware('auth');
Route::get('/program/{id}/clone', 'ProgramController@clone_program')->middleware('auth');
Route::get('/program/{id}/delete', 'ProgramController@delete')->middleware('auth');

Route::get('/program/{program_id}/discipline_unbind/{discipline_id}', 'DisciplineController@unbind_discipline')->middleware('auth');
Route::post('/program/discipline_bind', 'DisciplineController@bind_discipline')->middleware('auth');

//добавить редактирование и удаление!
//
//

// Управление потоками
Route::get('/streams', function(){return view('streams');});
Route::get('/stream/add', function(){return view('streamadd');});
Route::get('/stream/{id}/edit', 'StreamController@edit')->middleware('auth');
Route::post('/stream/add', 'StreamController@add')->middleware('auth');
Route::post('/stream/{id}/store', 'StreamController@store')->middleware('auth');
Route::post('/stream/{stream_id}/program_bind', 'StreamController@bind_program')->middleware('auth');
Route::get('/stream/{stream_id}/program_unbind/{program_id}', 'StreamController@unbind_program')->middleware('auth');

// Управление группами
Route::get('/group/add/{id}', function($id){return view('groupadd', ['id' => $id]);});
Route::get('/group/{id}/edit', 'GroupController@edit')->middleware('auth');
Route::post('/group/add', 'GroupController@add')->middleware('auth');
Route::get('/group/{id}/addstudents', function($id){return view('groupaddstudents', ['id' => $id]);})->middleware('auth');
Route::post('/group/addstudents', 'GroupController@add_students')->middleware('auth');
Route::post('/group/{id}/store', 'GroupController@store')->middleware('auth');
Route::get('/student/{id}/edit', 'StudentController@edit')->middleware('auth');
Route::post('/student/{id}/store', 'StudentController@store')->middleware('auth');


// Расписание
Route::get('/timetable', function(){return view('timetable');})->middleware('auth');
Route::get('/rasp', 'RaspController@view')->middleware('auth');
Route::get('/rasp/delete/{id}', 'RaspController@delete')->middleware('auth');
Route::get('/rasp/edit/{id}', 'RaspController@edit')->middleware('auth');
Route::post('/rasp/edit/{id}', 'RaspController@store')->middleware('auth');
Route::get('/raspadd/{date}/{room}', 'RaspController@add')->middleware('auth');

// Журнал

Route::get('/journal', 'JournalController@index')->middleware('auth');
Route::get('/journal/{date}', 'JournalController@index')->middleware('auth');
Route::get('/journal/item/{id}', 'JournalController@show')->middleware('auth');
Route::post('/journal/item/update', 'JournalController@update')->middleware('auth');

// Нагрузка
Route::get('/workload', function() {return view('workload');})->middleware('auth');
Route::get('/workload/get/{id}', 'WorkloadController@take_workload')->middleware('auth');
Route::get('/workload/edit/{id}', function($id) {return view('workloadedit', ['id' => $id]);})->middleware('auth');
Route::post('/workload/edit/{id}', 'WorkloadController@update_workload')->middleware('auth');
Route::post('/workload/get/{id}', 'WorkloadController@store_workload')->middleware('auth');
Route::get('/workload/split/{id}', 'WorkloadController@split_workload')->middleware('auth');

Route::get('/workload/cancel/{id}', 'WorkloadController@cancel_workload')->middleware('auth');

// ajax маршруты
Route::get('/ajax/workload/{date}/{teacher_id}', 'WorkloadController@get_workload')->middleware('auth');
Route::get('/ajax/classrooms/{date}', 'WorkloadController@get_classrooms')->middleware('auth');
