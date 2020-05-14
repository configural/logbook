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
        $discipline->name = $request->name;
        $discipline->hours = $request->hours;
        $discipline->active = $request->active;
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
        $discipline->name = $request->name;
        $discipline->active = $request->active;
        $discipline->hours = $request->hours;
        $discipline->save();
        return view('disciplines');
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
    

    
    
}
