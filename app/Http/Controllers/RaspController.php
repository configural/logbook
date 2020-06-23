<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rasp;
use Illuminate\Support\Facades\Auth;

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
        $rasp = new Rasp();
        $rasp->date = $date;
        $rasp->pair_id = $pair;
        $rasp->user_id = Auth::user()->id;
        $rasp->room_id = $room;
        $rasp->save();
        return redirect(url('raspedit')."/". $rasp->id);

    }
    
    function edit($id) {
        $rasp = Rasp::find($id);
        return view('raspedit', ['rasp' => $rasp]);
    }
    
    function store(Request $request) {
        $rasp = Rasp::find($request->id);
        $rasp->date = $request->date;
        $rasp->pair_id = $request->pair_id;
        $rasp->timetable_id = $request->timetable_id;
        $rasp->room_id = $request->room_id;
        $rasp->interval = $request->interval;
        $rasp->save();
        return redirect(url('rasp')."?date=".$rasp->date);
    }
}
