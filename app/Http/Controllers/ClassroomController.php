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
    
}
