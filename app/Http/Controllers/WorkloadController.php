<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timetable;
use App\Rasp;
use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Facades\Session;

class WorkloadController extends Controller
{
    
    public function workload_add_manual(Request $request) {
        $timetable = new Timetable();
        $timetable->fill($request->all());
        //dump($timetable);
        $timetable->save();
        return redirect(route('workload'));
        
        
        
    }
    
    public function take_workload($id) {
       $timetable = Timetable::find($id);
       return view('workloadadd', ['timetable' => $timetable]);

    }
    
    public function store_workload(Request $request) {
       $timetable = Timetable::find($request->id);
       $timetable->month = $request->month;
       if ($timetable->save()) {
       DB::table('teachers2timetable')->insert(['teacher_id' => Auth::user()->id, 'timetable_id' => $request->id]);}
       return redirect('workload');#'.$request->id);
    }
    
    public function update_workload(Request $request) {
        $timetable = Timetable::find($request->id);
        $timetable->month = $request->month;
        DB::table('teachers2timetable')->where('timetable_id', $request->id)->delete();
        if (is_array($request->teachers)){
            foreach($request->teachers as $teacher_id) {
                $tmp = DB::table('teachers2timetable')->insert(['timetable_id' => $request->id, 'teacher_id' => $teacher_id]);
                }
            }
            $timetable->save();
       //return redirect('workload#'.$request->id);
        $rasp = Rasp::where('timetable_id', $request->id)->first();
        isset($rasp->date) ? $rasp_date = $rasp->date : $rasp_date = "";
        
       //if ($rasp_date) {return redirect("rasp/?date" . $rasp_date);
       //} else {
       //return redirect('workload');}
       session_start();
            switch($_SESSION["work_with"]) {
                case "workload": { return redirect('workload/?stream_id=' . $_SESSION["stream_id"]);}
                case "rasp": { return redirect("rasp/?date=" . $rasp->date);}
                default: {return redirect(route('workload'));}
            }
            
    }
    
    public function delete_workload($id) {
        Timetable::find($id)->delete();
        return redirect('workload');
    }
    
    public function cancel_workload($id) {
       DB::table('teachers2timetable')->where(['teacher_id' => Auth::user()->id, 'timetable_id' => $id])->delete();
        return redirect('workload');//#'.$id);
    }    
    
    public function split_workload($id) {
        $error = Array();
        $w1 = Timetable::find($id);
        if ($w1->rasp_id) $error[] = "Эта нагрузка уже внесена в расписание!";
        if (!is_null($w1->subgroup)) $error[] = "Это уже подгруппа, ее нельзя разбивать!";
        
        if (count($error) == 0) {
            
            $subgroup_count = $w1->group->subgroup_count;
            $w1->subgroup = 1;
            $w1->save();
            
            for ($i = 1; $i < $subgroup_count; $i++) {
            $w2 = new Timetable();
            $w2->group_id =  $w1->group_id;
            $w2->block_id =  $w1->block_id;
            $w2->hours =  $w1->hours;
            $w2->month =  $w1->month;
            $w2->lessontype = $w1->lessontype;
            $w2->subgroup = $i + 1;
            $w2->save();}
        
            //return redirect('workload#'.$id);
            return redirect('workload');
        } else {
            echo "что-то пошло не так!";
             dump($w1);
        }
       
        
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
    
    public function get_group_blocks($group_id) {
        $group = \App\Group::find($group_id);
        $programs = $group->stream->programs;
        echo "<label>Дисциплина из программы:</label><select name='block_id' class='form-control-static' required>";
        foreach($programs as $p) {
            $discipline = $p->disciplines;    
            foreach($discipline as $d) {
                $blocks = $d->active_blocks;
                echo "<option value='' disabled>" . $d->name . "</option>";
                
                foreach ($blocks as $b ) {
                    echo "<option value=" . $b->id . " data-discipline=" . $d->id. " data-program=" . $p->id . ">- " . str_limit($b->name, 200) . "</option>";
                }
            }
        }
        echo "</select>";
    }


    public function get_group_disciplines($group_id) {
        $group = \App\Group::find($group_id);
        $programs = $group->stream->programs;
        echo "<label>Дисциплина:</label><select name='discipline_id' class='form-control-static' required>";
        foreach($programs as $p) {
            $discipline = $p->disciplines;    
            foreach($discipline as $d) {
                echo "<option value='" . $d->id . "' >" . $d->name . "</option>";
            }
        }
        echo "</select>";
    }
    
    public function get_group_programs($group_id) {
        $group = \App\Group::find($group_id);
        $programs = $group->stream->programs;
        echo "<label>Программа:</label><select name='program_id' class='form-control-static' required>";
        foreach($programs as $p) {
            
            echo "<option value='" . $p->id . "' >" . $p->name . "</option>";
        }
        echo "</select>";
    }    
}
