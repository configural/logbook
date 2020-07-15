<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timetable;
use App\Student;
use App\Block;
use App\Journal;
use App\Rasp;
use Illuminate\Support\Facades\Auth;


class JournalController extends Controller
{
    
    public function index() {
            $user_id = Auth::user()->id;
            $timetable = Timetable::select()->where('teacher_id', $user_id)->whereNotNull('rasp_id')->get();
            //dump($timetable);
            foreach ($timetable as $t) {
                $rasp = Rasp::select()->where('timetable_id', $t->id)->get();
                foreach($rasp as $r) {
                    echo $r->id;
                }
            }
            
    }
//
    public function show(Request $request) {
            $rasp_id = $request->id;
            $rasp = \App\Rasp::find($rasp_id);
            
            $journal = Journal::select()->where('rasp_id', $rasp->id)->get();
                                   
            if ($journal->count()){
            // переходим во вью    
            } else {
            // создаем запись журнала и переходим во вью
            }
                
            
    }
       
      
    
    public function update(Request $request) {
        // сериализация массива "Посещаемость"
        
        count(Journal::find($request->id)) ? $journal = Journal::find($request->id) : $journal = new Journal();
        
        $journal->timetable_id = $request->timetable_id;
        $journal->teacher_id = Auth::user()->id;
        $journal->l_hours = $request->l_hours;
        $journal->p_hours = $request->p_hours;
        $journal->attendance = serialize($request->attendance);
        
        
        $journal->save();
        return view('home');
        
        
    }
    
}
