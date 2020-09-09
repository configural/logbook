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
    
    public function delete($id) {
        $student = Student::find($id);
        $group_id = $student->group_id;
        $student->delete();
        return redirect('group/'.$group_id.'/edit');    }    
}
