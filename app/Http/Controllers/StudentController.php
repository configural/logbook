<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;

class StudentController extends Controller
{
    //
    public function edit($id) {
        $student = Student::find($id);
        return view('studentedit', ['student' => $student]);
    }
    
    public function store (Request $request) {
        $student = Student::find($request->id);
        $r = $request->all();
        $student->fill($r);
        $student->save();
        return redirect('group/'.$student->group_id.'/edit');
    }
}
