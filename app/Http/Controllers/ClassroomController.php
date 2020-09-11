<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classroom;

class ClassroomController extends Controller
{
    //
    public function edit($id) {
        $classroom = Classroom::find($id);
        return view('classroomedit', ['classroom' => $classroom]);
    }
    
    
    public function store(Request $request)
    {
      $room = $request->all();
      $classroom = Classroom::find($request->id);
      if (empty($classroom)) {
          $classroom = new Classroom();
      }
      $classroom->fill($room);
           
      $classroom->save();
      return redirect(url('classrooms'));
        
    }
    
    public function classroom_busy($room_id, $date) {
        $busy = \App\Rasp::where('room_id', $room_id)->where('date', $date)->get();
        $count = 0;
        foreach ($busy as $b) {
            echo "<br/>";
            echo $b->start_at;
            echo " - ";
            echo $b->finish_at;
            $count ++;
        }
        if ($count == 0){
            echo "Аудитория свободна весь день!";
        }
        
    }
    
}
