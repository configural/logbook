<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timetable;
use App\Student;
use App\Block;
use App\Journal;
use Illuminate\Support\Facades\Auth;


class JournalController extends Controller
{
    //
    public function show(Request $request) {
        
            $timetable = Timetable::select()->where('id', $request->id)->first();
            if (count($timetable)) {
            $students = Student::select()->where('group_id', $timetable->group_id)->get();
            $block = Block::select()->where('id', $timetable->block_id)->first();
            $journal = Journal::select()->where('timetable_id', $timetable->id)->first();
            if (count($journal)) {
              $journal->attendance = unserialize($journal->attendance);
            } else {$journal = new Journal();}
            }
        

        
       return view('journal', ['timetable' => $timetable, 'students' => $students, 'journal' => $journal, 'block' => $block ]);
       
       
       
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
