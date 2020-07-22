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
        dump($request);
//$student->fill($request);
        dump($student);
    }
}
