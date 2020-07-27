<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discipline;
use Illuminate\Support\Facades\DB;


class DisciplineController extends Controller
{
    //
    
    public function view(Request $request) {
        $discipline = Discipline::find($request->id);
        return view('discipline', ['discipline' => $discipline]);
    }
    
    
    public function add(Request $request) {
        $discipline = new Discipline;
        $new_discipline = $request->all();
        $discipline->fill($new_discipline);
        $discipline->save();
        return view('disciplines');
        
    }
    
    public function edit(Request $request) {
        $id = $request->id;
        $discipline = Discipline::find($id);
        return view('disciplineedit', ['discipline' => $discipline]);
        
    }
    
    public function store(Request $request) {
        $discipline = Discipline::find($request->id);
        $new_discipline = $request->all();
        $discipline->fill($new_discipline);
        $discipline->save();
        
        return redirect('disciplines');
    }
    
    public function bind_discipline(Request $request) {
        $program_id = $request->program_id;
        $discipline_id = $request->discipline_id;
        DB::table('discipline2program')
                ->insert(['program_id' => $program_id, 'discipline_id' => $discipline_id]);
        return redirect('program/'.$program_id);
                
    }

    public function unbind_discipline($program_id, $discipline_id) {
        DB::table('discipline2program')
                ->where('program_id', $program_id)
                ->where('discipline_id', $discipline_id)
                ->limit(1)
                ->delete();
        return redirect('program/'.$program_id);
                
    }
    
    public function clone_discipline (Request $request) {
        $discipline0 = Discipline::find($request->id);
        $discipline1 = $discipline0->replicate(); // клонируем программу
        $discipline1->name = "[клон от " . date("d.m.Y H:i") . "] - " . $discipline1->name;
        $discipline1->save();
        
        $blocks = \App\Block::select()->where('discipline_id', $request->id)->get();
        foreach ($blocks as $block) {
            $newblock = new \App\Block();
            $newblock->name = $block->name;
            $newblock->discipline_id = $discipline1->id;
            $newblock->active = $block->active;
            $newblock->l_hours = $block->l_hours;
            $newblock->p_hours = $block->p_hours;
            $newblock->type_id = $block->type_id;
            $newblock->save();
            
        }
        
        
       
        return redirect(url('/disciplines'));
    }
    
    
}
