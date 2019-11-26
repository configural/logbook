<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Discipline;


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
        $discipline->save();
        return view('disciplines');
    }
}
