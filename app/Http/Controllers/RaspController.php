<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rasp;
use Illuminate\Support\Facades\Auth;
use DB;
use Carbon\Carbon;

class RaspController extends Controller
{
    //
    function view(Request $request)
    {   if (!isset($request->date)) {
    $date = date("Y-m-d");
    } else {
        $date = $request->date;
    }
        return view('rasp', ['date' => $date]);
    }
    
    
    function raspview(Request $request)
    {   if (!isset($request->date)) {
    $date = date("Y-m-d");
    } else {
        $date = $request->date;
    }
        return view('raspview', ['date' => $date]);
    }
        
    
    
    function add($date, $room)
    {
        \App\Classroom::block_classroom($date, $room);
        return view('raspadd', ['date' => $date, 'room' => $room]);

    }
   
    // переход во вью редактирование
    function edit($id) {
        $rasp = Rasp::find($id);
        // добавить блокировку
        return view('raspedit', ['rasp' => $rasp]);
    }
    
    
    // сохранение элемента расписания с проверкой занятости преподов, аудиторий и группы
    function store(Request $request) {
        if ($request->id) {
        $rasp = Rasp::find($request->id);
        } else {
            $rasp = new Rasp;
        }
        $rasp->date = $request->date;
        $rasp_date1 = $request->date_copy;
        //dump($rasp_date1);
       // $rasp->pair_id = $request->pair_id;
        $rasp->timetable_id = $request->timetable_id;
        $rasp->room_id = $request->room_id;
        $rasp->start_at = mb_substr($request->start_at, 0, 5);
        $rasp->finish_at = mb_substr($request->finish_at, 0, 5);
        
        $errors = Array();
        // свободна ли аудитория? правильно ли указана длительность?
        $aud_free = true;
        $union_available = false;
        $check_rasp = Rasp::select()->where('id', '!=', $request->id)->where('room_id', $request->room_id)->where('date', $request->date)->get();
        foreach($check_rasp as $check) {
            $check->start_at = mb_substr($check->start_at, 0, 5);
            $check->finish_at = mb_substr($check->finish_at, 0, 5);
            $e=0;            
            //dump([$rasp->start_at, $check->start_at, $rasp->start_at, $check->finish_at]);
            if (($rasp->start_at > $check->start_at) && ($rasp->start_at < $check->finish_at)) {$aud_free = false; $e=1;}
            if (($rasp->finish_at > $check->start_at) && ($rasp->finish_at < $check->finish_at)) {$aud_free = false; $e=2;}
            if (($rasp->start_at > $check->start_at) && ($rasp->finish_at < $check->finish_at)) {$aud_free = false;  $e=3;}
            if (($rasp->start_at < $check->start_at) && ($rasp->finish_at > $check->finish_at)) {$aud_free = false; $e=4;}
        
            //dump($e);
            }
        // можно ли присоединить нагрузку (тот же препод и та же тема)?
        $check_rasp = Rasp::select()->where('room_id', $request->room_id)->where('date', $request->date)
                ->where('start_at', $request->start_at)->where('finish_at', $request->finish_at)->get();
        
        foreach($check_rasp as $check) {
            
            if ($rasp->timetable->block_id == $check->timetable->block_id
                    and $rasp->timetable->lessontype == $check->timetable->lessontype) $union_available = true;
        }
       if ($aud_free || $union_available) {
        $rasp->save();
        DB::table('timetable')->where('id', $rasp->timetable_id)->update(['rasp_id' => $rasp->id]);
        // снять блокировку
        \App\Classroom::unblock_classroom($rasp_date1, $rasp->room_id);
        return redirect(url('rasp')."?date=".$rasp_date1);
        }
        else {
            return view('info', ["html" => "Аудитория в это время занята. Объединение занятий невозможно."]);}
    }
    
    // удаление из расписания + удаление записи в журнале, если она есть
    function delete($id) {
        DB::table('timetable')->where('rasp_id', $id)->update(['rasp_id' => NULL]);
        $rasp = Rasp::find($id);
        \App\Classroom::unblock_classroom($rasp->date, $rasp->room_id);
        // удаление журнала
        $journal = \App\Journal::where('rasp_id', $rasp->id)->first();
        if (isset($journal)) {$journal->delete();}
        $rasp->delete();
        return redirect(url('rasp')."?date=".$rasp->date);
    }
    
    
    // мое расписание
    function my_rasp(Request $request) {
        
        $request->date1 ? $date1 = $request->date1 : $date1 = date("Y-m-d");
        $request->date2 ? $date2 = $request->date2 : $date2 = Carbon::now()->addMonth()->format("Y-m-d");
        foreach(Auth::user()->timetable() as $t) {
            $rasp = $t->rasp_id;
        }
        return view('raspmy', ['date1' => $date1, 'date2' => $date2]);
    }
    

    
    function rasp_group_ajax(Request $request) {
        $group_id = $request->group_id;
        $timetable = \App\Timetable::select()
                ->where('group_id', $group_id)
                ->get();
       
        echo "<table class='table table-bordered' id='sortTable'>";
        echo "<thead><tr>"
                . "<th>Занятие</th>"
                . "<th>Тема</th>"
                . "<th>Преподаватель</th>"
                . "<th>Месяц</th>"
                . "<th>Дата</th>"
                . "<th>Аудитория</th>"
                . "<th>Начало</th>"
                . "<th>Конец</th>"
                . "<th></th>"
                . "</tr></thead><tbody>";
        
        foreach($timetable as $t) {
            echo "<tr>";

            if (isset($t->lesson_type->name)) {echo "<td>" .$t->hours ."ч. - " .$t->lesson_type->name;  
                                 if ($t->subgroup) { echo ", " . $t->subgroup . "&nbsp;подгруппа";}
                                 echo "</td>";
                                 } else {echo "<td></td>";}
            if (isset($t->block->name)) {echo "<td>".str_limit($t->block->name, 50, '...') ."</td>";
                                 } else {echo "<td></td>";}

            if (isset($t->teachers)) {echo "<td>";
                                      foreach($t->teachers as $teacher) {
                                          echo $teacher->secname() . " ";
                                      }  
                                     echo "</td>";
                                 } else {echo "<td></td>";}          
            
            echo "<td>". sprintf("%02d", $t->month) ."</td>";
            if (isset($t->rasp))
            {
            if ($t->rasp->date) {echo "<td>" . \Logbook::normal_date($t->rasp->date) . " </td>";} else echo "<td>-</td>";
            if ($t->rasp->classroom) {echo "<td>" . $t->rasp->classroom->name . " </td>";} else echo "<td>-</td>";
            if ($t->rasp->start_at) {echo "<td>" . str_limit($t->rasp->start_at,5, '') . " </td>";} else echo "<td>-</td>";
            if ($t->rasp->finish_at) {echo "<td>" . str_limit($t->rasp->finish_at,5, '') . " </td>";} else echo "<td>-</td>";
            
            }
            
            else {echo "<td>-</td><td>-</td><td>-</td><td>-</td>";}            
            
            if (count($t->teachers)) {
            echo "<td><button class='btn btn-success btnChange' data-timetable_id=" . $t->id. "  data-toggle='modal' data-target='#myModal'>Назначить</button></td>";
            } else {
            echo "<td>Нагрузка не распределена</td>";
            }
            
            echo "</tr>";
        }
        echo "</tbody></table>";
        
        
    }
   
    
    function edit_modal($timetable_id) {
       
        $timetable = \App\Timetable::selectRaw('timetable.*')
                ->leftjoin('rasp', 'timetable.rasp_id', '=', 'rasp.id')
                ->where('timetable.id', $timetable_id)
                ->first();
        $teachers = serialize($timetable->teachers->toArray());
        
        return view('modal.rasp_edit_modal', ['timetable' => $timetable, 'teachers' => $teachers]);
    }
    
    function check_all(Request $request) {
       // dump($request);
        $group_id = html_entity_decode($request->group_id);
        $date = html_entity_decode($request->date);
        $room_id = html_entity_decode($request->room_id);
        $start_at = html_entity_decode($request->start_at);
        $finish_at = html_entity_decode($request->finish_at);
        $teachers = unserialize(html_entity_decode($request->teachers));
        
        if (!$date) $date = '1970-01-01';
        if (!$start_at) $start_at = '00:00:00';
        if (!$finish_at) $finish_at = '00:00:00';
      echo "<table valign='top'><tr>";  
// проверяем аудиторию в этот день
      echo "<td>";
        $rasp = \App\Rasp::select('rasp.*')
                ->join('timetable', 'timetable.rasp_id', '=', 'rasp.id')
                ->where('timetable.group_id', $group_id)
                ->where('rasp.date', $date)
                ->where('rasp.room_id', $room_id)
                ->orderby('rasp.start_at')
                ->get();
        if ($rasp->count()) {
        echo "Аудитория занята:<br>";
        foreach($rasp as $r) {
            if (\Logbook::time_cross([$start_at, $finish_at], [$r->start_at, $r->finish_at]))
            {echo  "<span class='cross'>" . $r->start_at . " - ". $r->finish_at . "</span><br/>";}
            else
            {echo  "<span class=''>" . $r->start_at . " - ". $r->finish_at . "</span><br/>";}
        }
        }
       echo "</td><td>"; 
// проверяем занятость группы
        $rasp = \App\Rasp::select('rasp.*')
                ->join('timetable', 'timetable.rasp_id', '=', 'rasp.id')
                ->where('timetable.group_id', $group_id)
                ->where('rasp.date', $date)
                ->orderby('rasp.start_at')
                ->get();
        if ($rasp->count()) {
            echo "Группа занята:<br>";
        foreach($rasp as $r) {
            if (\Logbook::time_cross([$start_at, $finish_at], [$r->start_at, $r->finish_at]))
            {echo  "<span class='cross'>" . $r->start_at . " - ". $r->finish_at . "</span><br/>";}
            else
            {echo  "<span class=''>" . $r->start_at . " - ". $r->finish_at . "</span><br/>";}
        }
        }
        echo "</td><td>";
// проверяем занятость преподавателей
    foreach($teachers as $teacher) {
        $teacher_id = $teacher["id"];
         $rasp = \App\Rasp::selectRaw('rasp.*, users.name as uname')
                ->join('timetable', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->join('users', 'users.id', '=', 'teachers2timetable.teacher_id') 
                ->where('rasp.date', $date)
                ->where('users.id', $teacher_id)
                ->orderby('rasp.start_at')
                ->get();
        if ($rasp->count()) {
        echo "Преподаватель занят:<br>";
        foreach($rasp as $r) {
            if (\Logbook::time_cross([$start_at, $finish_at], [$r->start_at, $r->finish_at]))
            {echo  "<span class='cross'>" . $r->start_at . " - ". $r->finish_at . "</span><br/>";}
            else
            {echo  "<span class=''>" . $r->start_at . " - ". $r->finish_at . "</span><br/>";}
        }
               
        }
    }
    echo "</td></tr></table>";
        
        //
  
    }
    
    function ajax_update(Request $request) {
        $timetable_id = $request->timetable_id;
        $date = $request->date;
        $start_at = $request->start_at;
        $finish_at = $request->finish_at;
        $room_id = $request->room_id;
        
        $timetable = \App\Timetable::find($timetable_id);
        if ($timetable->rasp_id) {
            $rasp = \App\Rasp::find($timetable->rasp_id);
            $rasp->date = $date;
            $rasp->start_at = $start_at;
            $rasp->finish_at = $finish_at;
            $rasp->room_id = $room_id;
            $rasp->timetable_id = $timetable->id;
            $rasp->save();
        }
        else {
            $rasp = new Rasp();
            $rasp->date = $date;
            $rasp->start_at = $start_at;
            $rasp->finish_at = $finish_at;
            $rasp->room_id = $room_id;
            $rasp->timetable_id = $timetable_id;
            $rasp->save();
            $timetable->rasp_id = $rasp->id;
            $timetable->save();
        }
        
        
    }
    
    
}
