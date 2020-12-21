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
        $program->project_hours = $request->project_hours;
        
        $program->active = $request->active;
        $program->year = $request->year;
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
        $program->project_hours = $request->project_hours;
        $program->active = $request->active;
        $program->year = $request->year;
        $program->save();
        return redirect(route('programs'));
    }
    
    public function clone_program (Request $request) {
        $program = Program::find($request->id);
        $program_clone = $program->replicate(); // клонируем программу
        $program_clone->name = "[клон от " . date("d.m.Y H:i") . "] - " . $program_clone->name;
        $program_clone->save();
        
        $disciplines = $program->disciplines; // ищем прикрепленные дисциплины и создаем привязываем их к свежесозданной программе
        foreach($disciplines as $d) {
            $discipline = \App\Discipline::find($d->id);
            $discipline_clone = $discipline->replicate();
            $discipline_clone->save();
            DB::table('discipline2program')->insert(['program_id' => $program_clone->id, 'discipline_id' => $discipline_clone->id ]);
            
            foreach($discipline->blocks as $block) { // клонируем темы
                $block = \App\Block::find($block->id);
                $block_clone = $block->replicate();
                $block_clone->discipline_id = $discipline_clone->id;
                $block_clone->save();
            }
        }
        return redirect(url('/programs'));
    }
    
    public function delete(Request $request) {
        $program = Program::find($request->id);
        foreach($program->disciplines as $discipline) {
            $discipline->active = 0;
            $discipline->save();
            foreach($discipline->blocks as $block) {
                $block->active = 0;
                $block->save();
            }
        }
        $program->active = 0;
        $program->save();
        //$program->delete();
        return redirect(url('/programs'));
    }
    
}
