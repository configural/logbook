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
    
    public function index(Request $request) {
        if ($request->date) { 
            $date = $request->date;
        }
        else {
            $date = date('Y-m-d');
        }
        return view('journal', ['date' => $date]);
            
    }
//
    public function show(Request $request) {
            $rasp_id = $request->id;
            $rasp = \App\Rasp::find($rasp_id);
            
            if ($rasp->date > date("Y-m-d")) {
                return view('info', ['html' => 'Этот день еще не наступил!']);
            }
            
            
            $journal = Journal::select()->where('rasp_id', $rasp->id)->first();
            
            
            if ($journal){
            // переходим во вью   l
                                
            } else {
            // создаем запись журнала и переходим во вью
                $journal = new Journal();
                $journal->teacher_id = Auth::user()->id;
                $journal->rasp_id = $rasp_id;
                
                $journal->attendance = serialize([]);
                $journal->save();
            }
            
            
            $group_id = $rasp->timetable->group_id;
            $subgroup = $rasp->timetable->subgroup;
            if (isset($rasp->timetable->block->name)) {
                $block_name = $rasp->timetable->block->name;
                } else {$block_name = "";}
            $hours = $rasp->timetable->hours;
            $lessontype = $rasp->timetable->lesson_type->name;
            $attendance = unserialize($journal->attendance);
            
          //  dump($attendance);
            
            return view('journalitem', ['id' => $journal->id, 
                    'group_id' => $group_id,
                    'subgroup' => $subgroup, 
                    'block' => $block_name,
                    'hours' => $hours,
                    'lessontype' => $lessontype,
                    'attendance' => $attendance]);
                
            
            
    }
       
      
    
    public function update(Request $request) {
        // сериализация массива "Посещаемость"
        //dump($request);
        $journal = Journal::find($request->id);
        //dump($journal);
        if (is_array($request->attendance)) {
            $journal->attendance = serialize($request->attendance);
            } else {
                $journal->attendance = serialize([]);
            }
        $journal->save();
        return redirect(url('journal')."?date=" . $journal->rasp->date);
    }
    
}
