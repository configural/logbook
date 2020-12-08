<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rasp;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class RaspController extends Controller
{
    //
    function view(Request $request)
    {   if (!isset($request->date)) {
    $date = date("Y-m-d");
    } else {
        $date = $request->date;
    }
        return view('rasp', ['date' => $date]);
    }
    
    
    function raspview(Request $request)
    {   if (!isset($request->date)) {
    $date = date("Y-m-d");
    } else {
        $date = $request->date;
    }
        return view('raspview', ['date' => $date]);
    }
        
    
    
    function add($date, $room)
    {
        \App\Classroom::block_classroom($date, $room);
        return view('raspadd', ['date' => $date, 'room' => $room]);

    }
   
    // переход во вью редактирование
    function edit($id) {
        $rasp = Rasp::find($id);
        // добавить блокировку
        return view('raspedit', ['rasp' => $rasp]);
    }
    
    
    // сохранение элемента расписания с проверкой занятости преподов, аудиторий и группы
    function store(Request $request) {
        if ($request->id) {
        $rasp = Rasp::find($request->id);
        } else {
            $rasp = new Rasp;
        }
        $rasp->date = $request->date;
        $rasp_date1 = $request->date_copy;
        //dump($rasp_date1);
       // $rasp->pair_id = $request->pair_id;
        $rasp->timetable_id = $request->timetable_id;
        $rasp->room_id = $request->room_id;
        $rasp->start_at = mb_substr($request->start_at, 0, 5);
        $rasp->finish_at = mb_substr($request->finish_at, 0, 5);
        
        $errors = Array();
        // свободна ли аудитория? правильно ли указана длительность?
        $aud_free = true;
        $union_available = false;
        $check_rasp = Rasp::select()->where('id', '!=', $request->id)->where('room_id', $request->room_id)->where('date', $request->date)->get();
        foreach($check_rasp as $check) {
            $check->start_at = mb_substr($check->start_at, 0, 5);
            $check->finish_at = mb_substr($check->finish_at, 0, 5);
            $e=0;            
            //dump([$rasp->start_at, $check->start_at, $rasp->start_at, $check->finish_at]);
            if (($rasp->start_at > $check->start_at) && ($rasp->start_at < $check->finish_at)) {$aud_free = false; $e=1;}
            if (($rasp->finish_at > $check->start_at) && ($rasp->finish_at < $check->finish_at)) {$aud_free = false; $e=2;}
            if (($rasp->start_at > $check->start_at) && ($rasp->finish_at < $check->finish_at)) {$aud_free = false;  $e=3;}
            if (($rasp->start_at < $check->start_at) && ($rasp->finish_at > $check->finish_at)) {$aud_free = false; $e=4;}
        
            //dump($e);
            }
        // можно ли присоединить нагрузку (тот же препод и та же тема)?
        $check_rasp = Rasp::select()->where('room_id', $request->room_id)->where('date', $request->date)
                ->where('start_at', $request->start_at)->where('finish_at', $request->finish_at)->get();
        
        foreach($check_rasp as $check) {
            
            if ($rasp->timetable->block_id == $check->timetable->block_id
                    and $rasp->timetable->lessontype == $check->timetable->lessontype) $union_available = true;
        }
       if ($aud_free || $union_available) {
        $rasp->save();
        DB::table('timetable')->where('id', $rasp->timetable_id)->update(['rasp_id' => $rasp->id]);
        // снять блокировку
        \App\Classroom::unblock_classroom($rasp_date1, $rasp->room_id);
        return redirect(url('rasp')."?date=".$rasp_date1);
        }
        else {
            return view('info', ["html" => "Аудитория в это время занята. Объединение занятий невозможно."]);}
    }
    
    // удаление из расписания + удаление записи в журнале, если она есть
    function delete($id) {
        DB::table('timetable')->where('rasp_id', $id)->update(['rasp_id' => NULL]);
        $rasp = Rasp::find($id);
        \App\Classroom::unblock_classroom($rasp->date, $rasp->room_id);
        // удаление журнала
        $journal = \App\Journal::where('rasp_id', $rasp->id)->first();
        if (isset($journal)) {$journal->delete();}
        $rasp->delete();
        return redirect(url('rasp')."?date=".$rasp->date);
    }
    
    
    // мое расписание
    function my_rasp(Request $request) {
        
        $request->date1 ? $date1 = $request->date1 : $date1 = date("Y-m-d");
        $request->date2 ? $date2 = $request->date2 : $date2 = Carbon::now()->addMonth()->format("Y-m-d");
        foreach(Auth::user()->timetable() as $t) {
            $rasp = $t->rasp_id;
        }
        return view('raspmy', ['date1' => $date1, 'date2' => $date2]);
    }
    
}
