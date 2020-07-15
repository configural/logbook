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
        // добавить блокировку
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
        
        // свободна ли аудитория?
        $aud_free = 1;
        $check_rasp = Rasp::select()->where('id', '!=', $request->id)->where('room_id', $request->room_id)->where('date', $request->date)->get();
        foreach($check_rasp as $check) {
            if (($rasp->start_at >= $check->start_at)&& ($rasp->start_at <= $check->finish_at)) {$aud_free = 0;}
            if (($rasp->finish_at >= $check->start_at) && ($rasp->finish_at <= $check->finish_at)) {$aud_free = 0;}
            if (($rasp->start_at >= $check->start_at) && ($rasp->finish_at <= $check->finish_at)) {$aud_free = 0;}
            if (($rasp->start_at <= $check->start_at) && ($rasp->finish_at >= $check->finish_at)) {$aud_free = 0;}
        }
        if ($aud_free) {
        
        $rasp->save();
        DB::table('timetable')->where('id', $rasp->timetable_id)->update(['rasp_id' => $rasp->id]);
        
        // снять блокировку
        return redirect(url('rasp')."?date=".$rasp->date);
        }
        else {
            dump($check_rasp);
            echo "Аудитория в это время занята! <a href=javascript:history.back(1)>вернуться</a>";}
        
    }
    
    function delete($id) {
        DB::table('timetable')->where('rasp_id', $id)->update(['rasp_id' => NULL]);
        $rasp = Rasp::find($id);
        $rasp->delete();
        // снять блокировку
        return redirect(url('rasp')."?date=".$rasp->date);
       
    }
}
