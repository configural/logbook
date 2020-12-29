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
    return view('home');
})->middleware('auth');

Auth::routes();

Route::get('/profile', function(){return view('userprofile');})->name('profile');
Route::post('/profile', 'UserController@update_profile');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'UserController@showUsers')->name('users')->middleware('auth');
Route::get('/user/add', function() {return view('useradd');})->middleware('auth');
Route::post('/user/add', 'UserController@add')->middleware('auth');
Route::get('/user/{id}/edit', 'UserController@edit')->middleware('auth');
Route::post('/user/{id}/store', 'UserController@store')->middleware('auth');
Route::get('/user/{user_id}/addcontract', function($id){ return view('usercontractadd', ['id' => $id]);})->middleware('auth');
Route::post('/user/{user_id}/addcontract', 'UserController@storecontract')->middleware('auth');

Route::get('/user/editcontract/{id}', 'UserController@editcontract')->middleware('auth');
Route::post('/user/editcontract/{id}', 'UserController@storecontract')->middleware('auth');
Route::get('/user/deletecontract/{id}', 'UserController@deletecontract')->middleware('auth');




// Управление списком кафедр
Route::get('/departments', function() {return view('departments');})->name('departments')->middleware('auth');

// Управление списком дисциплин
Route::get('/disciplines', function() {return view('disciplines');})->name('disciplines')->middleware('auth');
Route::get('/discipline/{id}', 'DisciplineController@view')->middleware('auth');
Route::get('/disciplines/add', function() {return view('disciplineadd');})->middleware('auth');
Route::get('/disciplines/{id}/edit', 'DisciplineController@edit')->middleware('auth');
Route::post('/disciplines/add', 'DisciplineController@add')->middleware('auth');
Route::post('/disciplines/{id}/store', 'DisciplineController@store')->middleware('auth');
Route::get('/disciplines/{id}/clone', 'DisciplineController@clone_discipline')->middleware('auth');


// Управление списком тематических блоков внутри дисциплин
Route::get('/blocks', function() {return view('blocks');})->name('blocks')->middleware('auth');
Route::post('/blocks', 'BlockController@quick_update')->middleware('auth');
Route::get('/block/add/{id}', function($id) {return view('blockadd', ['id'=>$id]);})->middleware('auth');
Route::get('/block/{id}/edit', 'BlockController@edit')->middleware('auth');
Route::post('/block/add', 'BlockController@add')->middleware('auth');
Route::post('/block/{id}/store', 'BlockController@store')->middleware('auth');
Route::get('/block/{id}/delete', 'BlockController@delete')->middleware('auth');

Route::get('/largeblocks', 'LargeblockController@show')->name('largeblocks')->middleware('auth');
Route::post('/largeblocks', 'LargeblockController@quick_update')->middleware('auth');


// Управление списком дополнительных образовательных программ 
Route::get('/programs', function(){ return view('programs');})->name('programs')->middleware('auth');
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
Route::get('/streams', function(){return view('streams');})->name('streams')->middleware('auth');
Route::get('/stream/add', function(){return view('streamadd');})->middleware('auth');;
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
Route::post('/group/{id}/import_asus', 'GroupController@import_asus')->middleware('auth');
Route::post('/group/addemptystudents', 'GroupController@add_empty_students')->middleware('auth');
Route::post('/group/addstudents', 'GroupController@add_students')->middleware('auth');
Route::post('/group/{id}/store', 'GroupController@store')->middleware('auth');
Route::get('/student/{id}/edit', 'StudentController@edit')->middleware('auth');
Route::get('/student/{id}/delete', 'StudentController@delete')->middleware('auth');
Route::post('/student/{id}/store', 'StudentController@store')->middleware('auth');


// Расписание
Route::get('/timetable', function(){return view('timetable');})->middleware('auth');
Route::get('/my_rasp', 'RaspController@my_rasp')->name('myrasp')->middleware('auth');
Route::get('/rasp', 'RaspController@view')->name('rasp')->middleware('auth');
Route::get('/rasp/delete/{id}', 'RaspController@delete')->middleware('auth');
Route::get('/rasp/edit/{id}', 'RaspController@edit')->middleware('auth');
Route::post('/rasp/edit/{id}', 'RaspController@store')->middleware('auth');
Route::get('/raspadd/{date}/{room}', 'RaspController@add')->middleware('auth');
Route::get('/room_unlock/{date}/{room}', function($date, $room_id){\App\Classroom::unblock_classroom($date, $room_id); return redirect(url('rasp')."?date=".$date);})->middleware('auth');
Route::get('/raspview', 'RaspController@raspview')->name('raspview')->middleware('auth');

// Журнал

Route::get('/journal', 'JournalController@index')->name('journal')->middleware('auth');
Route::get('/journal/{date}', 'JournalController@index')->middleware('auth');
Route::get('/journal/item/{id}', 'JournalController@show')->middleware('auth');
Route::post('/journal/item/update', 'JournalController@update')->middleware('auth');

// Нагрузка
Route::get('/workload', function() {return view('workload');})->name('workload')->middleware('auth');
Route::get('/workload_my', function() {return view('workloadmy');})->name('workloadmy')->middleware('auth');
Route::get('/workload_my_themes', function() {return view('workloadmythemes');})->name('workloadmythemes')->middleware('auth');
Route::get('/workload_my_themes_grouped', function() {return view('workloadmythemes_grouped');})->name('workloadmythemes_group')->middleware('auth');
Route::get('/workload/rebuild', 'WorkloadController@rebuild_workload')->middleware('auth');

Route::get('/workload/add', function() {return view('workloadaddmanual');})->middleware('auth');
Route::post('/workload/add', 'WorkloadController@workload_add_manual')->middleware('auth');
Route::get('/workload/get/{id}', 'WorkloadController@take_workload')->middleware('auth');
Route::get('/workload/delete/{id}', 'WorkloadController@delete_workload')->middleware('auth');
Route::get('/workload/edit/{id}', function($id) {return view('workloadedit', ['id' => $id]);})->middleware('auth');
Route::post('/workload/edit/{id}', 'WorkloadController@update_workload')->middleware('auth');
Route::post('/workload/get/{id}', 'WorkloadController@store_workload')->middleware('auth');
Route::get('/workload/split/{id}', 'WorkloadController@split_workload')->middleware('auth');
Route::get('/workload/cancel/{id}', 'WorkloadController@cancel_workload')->middleware('auth');

// Аудитории
Route::get('/classrooms', function() {return view('classrooms');})->name('classrooms')->middleware('auth');
Route::get('/classroom/add', function() {return view('classroomadd');})->middleware('auth');
Route::post('/classroom/add', 'ClassroomController@store')->middleware('auth');
Route::get('/classroom/edit/{id}', 'ClassroomController@edit')->middleware('auth');
Route::post('/classroom/edit/{id}', 'ClassroomController@store')->middleware('auth');

// Отчеты
Route::get('/reports/journal', function() {return view('report_journal');})->middleware('auth')->name('report_journal');
Route::get('/reports/journal/{user_id}', 'ReportController@user_journal_list')->middleware('auth');
Route::get('/reports/journal/view/{id}', 'ReportController@view_journal')->middleware('auth');
Route::get('/reports/rasp', function() {return view('report_rasp');})->name('print_rasp')->middleware('auth');
Route::post('/reports/rasp', 'ReportController@rasp_group')->middleware('auth');
Route::get('/reports/rasp_kafedra', 'ReportController@rasp_kafedra')->name('print_rasp_kafedra')->middleware('auth');
Route::get('/reports/tabel', 'ReportController@tabel')->name('tabel')->middleware('auth');
Route::get('/reports/tabel_freelance', 'ReportController@tabel_freelance')->name('tabel_freelance')->middleware('auth');
Route::get('/reports/no_journal', 'ReportController@no_journal')->name('no_journal')->middleware('auth');
Route::get('/reports/themes', 'ReportController@themes')->name('themes')->middleware('auth');
Route::post('/reports/themes', 'ReportController@themes')->middleware('auth');


// Медиаконтент
Route::get('/media', function() {return view('media');})->name('media')->middleware('auth');
Route::get('/my_media', function() {return view('media_my');})->name('my_media')->middleware('auth');
Route::get('/my_media/add', function() {return view('mediaaddteacher');})->name('my_media_add')->middleware('auth');
Route::post('/my_media/add', 'MediaController@store')->middleware('auth');
Route::get('/my_media/{id}/edit', 'MediaController@edit_my')->middleware('auth');
Route::post('/my_media/{id}/edit', 'MediaController@store')->middleware('auth');
Route::get('/mediaadd', function() {return view('mediaadd');})->name('mediaadd')->middleware('auth');
Route::get('/media/{id}/edit', 'MediaController@edit')->middleware('auth');
Route::get('/media/{id}/delete', 'MediaController@delete')->middleware('auth');
Route::post('/mediaadd', 'MediaController@store')->middleware('auth');
Route::post('/media/{id}/edit', 'MediaController@store')->middleware('auth');


// Внеаудиторная работа
Route::get('vneaud', function() {return view('vneaud');})->name('vneaud')->middleware('auth');
Route::get('vneaudmy', function() {return view('vneaudmy');})->name('vneaudmy')->middleware('auth');
Route::get('vneaud/add', function(){return view('vneaudadd');})->name('vneaudadd')->middleware('auth');
Route::get('vneaud/{id}/edit', 'VneaudController@edit')->middleware('auth');
Route::post('vneaud/add', 'VneaudController@store')->middleware('auth');
Route::post('vneaud/{id}/edit', 'VneaudController@store')->middleware('auth');
Route::get('vneaud/{id}/delete', 'VneaudController@delete')->middleware('auth');

// Вебинары
Route::get('webinars', function() {return view('webinars');})->name('webinars')->middleware('auth');
Route::get('webinar/add', function() {return view('webinaradd');})->name('webinaradd')->middleware('auth');





//
// 
// Тесты 
Route::get('tests', function() {return view('tests');})->name('tests');
Route::get('test/add', function() {return view('testadd');})->name('testadd');
Route::post('test/add', 'TestController@store_test');
Route::get('test/{id}/edit', 'TestController@edit_test');
Route::post('test/{id}/edit', 'TestController@store_test');
Route::get('test/{id}/questions', 'TestController@show_questions');
Route::get('test/{test_id}/addquestion', function($test_id) {return view('questionadd', ['test_id' => $test_id]);});
Route::post('test/{test_id}/addquestion', 'TestController@store_question');
Route::get('question/{id}/edit', 'TestController@edit_question');
Route::post('question/{id}/edit', 'TestController@store_question');


// ajax маршруты
Route::get('/ajax/workload/{date}/{teacher_id}', 'WorkloadController@get_workload')->middleware('auth');
Route::get('/ajax/classrooms/{date}', 'WorkloadController@get_classrooms')->middleware('auth');
Route::get('/ajax/teacher_busy/{user_id};{date};{start_at};{finish_at};{timetable_id}', 'UserController@teacher_busy')->middleware('auth');
Route::get('/ajax/group_busy/{group_id};{date};{start_at};{finish_at}', 'GroupController@group_busy')->middleware('auth');
Route::get('/ajax/classroom_busy/{room_id};{date}', 'ClassroomController@classroom_busy')->middleware('auth');
Route::get('/ajax/group_blocks/{group_id}', 'WorkloadController@get_group_blocks')->middleware('auth');
Route::get('/ajax/group_disciplines/{group_id}', 'WorkloadController@get_group_disciplines')->middleware('auth');
Route::get('/ajax/group_programs/{group_id}', 'WorkloadController@get_group_programs')->middleware('auth');
Route::get('/ajax/search/block/{text}', 'BlockController@search')->middleware('auth');
