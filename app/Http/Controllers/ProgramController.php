<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;

class ProgramController extends Controller
{
    //
        public function add(Request $request) {
        $program = new Program;
        $program->name = $request->name;
        $program->description = $request->description;
        $program->hours = $request->hours;
        $program->form_id = $request->form_id;
        $program->attestation_id = $request->attestation_id;
        $program->active = $request->active;
        $program->save();
        return view('programs');
        
    }
    
    public function store (Request $request) {
        $program = Program::find($request->id);
        $program->name = $request->name;
        $program->description = $request->description;
        $program->hours = $request->hours;
        $program->form_id = $request->form_id;
        $program->attestation_id = $request->attestation_id;
        $program->active = $request->active;
        $program->save();
        return view('programs');
    }
    
}
