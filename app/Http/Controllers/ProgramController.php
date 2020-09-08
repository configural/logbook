<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Program;
use DB;

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
        $program->attestation_hours = $request->attestation_hours;
        $program->vkr_hours = $request->vkr_hours;
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
        $program->attestation_hours = $request->attestation_hours;
        $program->vkr_hours = $request->vkr_hours;
        $program->active = $request->active;
        $program->save();
        return view('programs');
    }
    
    public function clone_program (Request $request) {
        $program0 = Program::find($request->id);
        $program1 = $program0->replicate(); // клонируем программу
        $program1->name = "[клон от " . date("d.m.Y H:i") . "] - " . $program1->name;
        $program1->save();
        
        $disciplines = $program0->disciplines; // ищем прикрепленные дисциплины и создаем привязываем их к свежесозданной программе
        foreach($disciplines as $d) {
            DB::table('discipline2program')->insert(['program_id' => $program1->id, 'discipline_id' => $d->id ]);
            }
        return redirect(url('/programs'));
    }
    
    public function delete(Request $request) {
        $program = Program::find($request->id);
        $program->delete();
        return redirect(url('/programs'));
    }
    
}
