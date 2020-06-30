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
    
    function add($date, $room, $pair)
    {
        // добавить блокировку
        return view('raspadd', ['date' => $date, 'room' => $room, 'pair' => $pair]);

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
        $rasp->pair_id = $request->pair_id;
        $rasp->timetable_id = $request->timetable_id;
        $rasp->room_id = $request->room_id;
        $rasp->interval = $request->interval;
        $rasp->save();
        DB::table('timetable')->where('id', $rasp->timetable_id)->update(['rasp_id' => $rasp->id]);
        
        // снять блокировку
        return redirect(url('rasp')."?date=".$rasp->date);
        
    }
    
    function delete($id) {
        DB::table('timetable')->where('rasp_id', $id)->update(['rasp_id' => NULL]);
        $rasp = Rasp::find($id);
        $rasp->delete();
        // снять блокировку
        return redirect(url('rasp')."?date=".$rasp->date);
       
    }
}
