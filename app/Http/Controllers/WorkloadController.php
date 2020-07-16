<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timetable;
use Illuminate\Support\Facades\Auth;
use DB;

class WorkloadController extends Controller
{
    //
    public function take_workload($id) {
       $timetable = Timetable::find($id);
       return view('workloadadd', ['timetable' => $timetable]);

    }
    
    public function store_workload(Request $request) {
       $timetable = Timetable::find($request->id);
       $timetable->month = $request->month;
       if ($timetable->save()) {
       DB::table('teachers2timetable')->insert(['teacher_id' => Auth::user()->id, 'timetable_id' => $request->id]);}
       return redirect('workload#'.$request->id);
    }
    
    public function update_workload(Request $request) {
        foreach($request->teachers as $teacher_id) {
            $tmp = DB::table('teachers2timetable')->where('teacher_id', $teacher_id)->where('timetable_id', $request->id)->get();
            dump($tmp);
        }
    }
    
    public function cancel_workload($id) {
       DB::table('teachers2timetable')->where(['teacher_id' => Auth::user()->id, 'timetable_id' => $id])->delete();
        return redirect('workload#'.$id);
    }    
    
    public function split_workload($id) {
        $error = Array();
        $w1 = Timetable::find($id);
        if ($w1->rasp_id) $error[] = "Эта нагрузка уже внесена в расписание!";
        if (!is_null($w1->subgroup)) $error[] = "Это уже подгруппа, ее нельзя разбивать!";
        if (count($error) == 0) {
            $w1->subgroup = 1;
            $w1->save();
            $w2 = new Timetable();
            $w2->group_id =  $w1->group_id;
            $w2->block_id =  $w1->block_id;
            $w2->hours =  $w1->hours;
            $w2->month =  $w1->month;
            $w2->lessontype = $w1->lessontype;
            $w2->subgroup = 2;
            $w2->save();
            return redirect('workload#'.$id);
        } else {
            echo "что-то пошло не так!";
        }
        dump($w1);
        
    }
    
    public function get_workload($date, $teacher_id) {
                
        $date1 = $date. " 00:00:00";
        $date2 = $date. " 23:59:59";
        $workload = Timetable::select()->where('teacher_id', $teacher_id)->whereBetween('start_at', [$date1, $date2])->get();
        if ($workload->count()) {
            echo "<strong>Загрузка преподавателя в этот день</strong>";
        echo "<table class='table table-bordered'>";
        echo "<tr><th>Начало</th><th>Часов</th><th>Группа</th><th>Тема</th></tr>";
        foreach ($workload as $w) {
            echo "<tr>";
            echo "<td>" . mb_substr($w->start_at, 11, 5) . "</td>";
            echo "<td>" . $w->hours. "</td>";
            echo "<td>". $w->group->name . "</td>";
            echo "<td>". $w->block->name . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {echo "Преподаватель в этот день свободен";}
    
        }
    
        
    public function get_classrooms($date) {
        $date1 = $date. " 00:00:00";
        $date2 = $date. " 23:59:59";       
        $classrooms = \App\Classroom::select()->get();
        echo "<table class='table table-bordered'>";
        foreach ($classrooms as $classroom) {
            echo "<tr>";
            echo "<td>" . $classroom->name . "</td>";
            
            $time = \App\Timetable::select()->where('room_id', $classroom->id)->whereBetween('start_at',[$date1, $date2])->get();
            foreach($time as $t) {
                echo "<td><small>" . $t->start_at . "<br>" . $t->group->name . "<br>" . $t->teacher->name . "<br>"  . mb_substr($t->block->name, 0, 30) . "</small></td>";
            }
            
            echo "</td>";
        }
        echo "</table>";
            
    }
}
