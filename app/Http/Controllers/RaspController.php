<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rasp;
use Illuminate\Support\Facades\Auth;
use DB;

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
    
    function add($date, $room)
    {
        \App\Classroom::block_classroom($date, $room);
        return view('raspadd', ['date' => $date, 'room' => $room]);

    }
    
    function edit($id) {
        $rasp = Rasp::find($id);
        // добавить блокировку
        return view('raspedit', ['rasp' => $rasp]);
    }
    
    function store(Request $request) {
        if ($request->id) {
        $rasp = Rasp::find($request->id);
        } else {
            $rasp = new Rasp;
        }
        $rasp->date = $request->date;
       // $rasp->pair_id = $request->pair_id;
        $rasp->timetable_id = $request->timetable_id;
        $rasp->room_id = $request->room_id;
        $rasp->start_at = $request->start_at;
        $rasp->finish_at = $request->finish_at;
        
        $errors = Array();
        // свободна ли аудитория? правильно ли указана длительность?
        $aud_free = true;
        $union_available = false;
        $check_rasp = Rasp::select()->where('id', '!=', $request->id)->where('room_id', $request->room_id)->where('date', $request->date)->get();
        foreach($check_rasp as $check) {
            if (($rasp->start_at >= $check->start_at)&& ($rasp->start_at <= $check->finish_at)) {$aud_free = false;}
            if (($rasp->finish_at >= $check->start_at) && ($rasp->finish_at <= $check->finish_at)) {$aud_free = false;}
            if (($rasp->start_at >= $check->start_at) && ($rasp->finish_at <= $check->finish_at)) {$aud_free = false;}
            if (($rasp->start_at <= $check->start_at) && ($rasp->finish_at >= $check->finish_at)) {$aud_free = false;}
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
        \App\Classroom::unblock_classroom($rasp->date, $rasp->room_id);

        return redirect(url('rasp')."?date=".$rasp->date);
        }
        else {
         
            echo "Аудитория в это время занята. Объединение занятий невозможно. <a href=javascript:history.back(1)>вернуться</a>";}
        
    }
    
    function delete($id) {
        DB::table('timetable')->where('rasp_id', $id)->update(['rasp_id' => NULL]);
        
        $rasp = Rasp::find($id);
        
        \App\Classroom::unblock_classroom($rasp->date, $rasp->room_id);
        
        $rasp->delete();
        
        return redirect(url('rasp')."?date=".$rasp->date);
       
    }
    
}
