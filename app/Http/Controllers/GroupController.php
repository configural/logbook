<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Student;

class GroupController extends Controller
{
    public function view(Request $request) {
        $group = Group::find($request->id);
        return view('group', ['group' => $group]);
    }
    
    // добавляем новый группу в поток
    public function add(Request $request) {
        $group = new Group;
        $group->name = $request->name; // название
        $group->description = $request->description; // описание
        $group->stream_id = $request->stream_id; // id потока
        $group->active = $request->active; // опубликовано?
        $group->subgroup_count = $request->subgroup_count; // количество подгрупп
        $group->save();
        return redirect('stream/'.$group->stream_id.'/edit');
        
    }
    
       
    
    public function edit(Request $request) {
        $id = $request->id;
        $group = Group::find($id);
        return view('groupedit', ['group' => $group]);
        
    }
    
    public function store(Request $request) {
        $group = Group::find($request->id);
        $group->name = $request->name; // название
        $group->description = $request->description; // описание
        $group->stream_id = $request->stream_id; // id потока
        $group->active = $request->active; // опубликовано?
        $group->subgroup_count = $request->subgroup_count; // количество подгрупп
        $group->save();
        return redirect('stream/'.$group->stream_id.'/edit');
    }
    
    public function add_empty_students(Request $request) {
        for ($i = 0; $i < $request->count; $i++) {
            $student = new Student;            
            $student->group_id = $request->group_id;
            $student->name = "student";
            $student->save();
        }
        return redirect('group/' . $request->group_id . '/edit');
    }
    
    
    public function add_students(Request $request) {
        $group_id = $request->group_id;
        $subgroup_count = Group::find($group_id)->subgroup_count;
        $divider = stripcslashes($request->divider);
        $import = str_replace($divider, ' ', $request->import); 
        $import = preg_replace("/ {2,}/", " ", $import);
        $strings = explode("\r\n", $import);
        $problems = array();
        $message = "";
        $count = 0;
        $subgroup = 1;
        foreach ($strings as $string) {
            $item = explode(' ', $string);
            $sono = trim($item[0]);
            $secname = trim($item[1]);
            $name = trim($item[2]);
            $fathername = trim($item[3]);
            if ((int)$sono and ($sono >= 100 and $sono<=9999) and (count($item) == 4)) {
                    $student_exist = Student::select()
                            ->where('sono', $sono)
                            ->where('secname', $secname)
                            ->where('name', $name)->count();
                    if ($student_exist == 0) {
                    $student = new Student();
                    $student->group_id = $group_id;
                    $student->secname = $item[1];
                    $student->name = $item[2];
                    $student->fathername = $item[3];
                    $student->sono = $sono;
                    $student->subgroup = $subgroup;
                    $student->save();
                    $count++;
                    $subgroup++;
                    if ($subgroup > $subgroup_count) $subgroup = 1;
                    } else {
                        
                    }
            } else {
                $problems[] = $item;                    
            }
        }   
       if (count($problems)) {
                    $message = "Успешно добавлено $count записей. Возникли проблемы - код СОНО должен быть цифровым и 4-значным";
                }  else  {
                    $message = "Успешно добавлено $count записей";
                }
        return view('groupaddstudents', ['id' => $group_id, 'problems' => $problems, 'message' => $message] );
    }

        public function group_busy($group_id, $date, $start_at, $finish_at) {
        $busy = false;
              
        $rasp = \App\Rasp::where('date', $date)->get();
        echo "<p><strong>У группы в этот день следующие занятия:</strong></p>";
        echo "<table class='table table-bordered'>";
        echo "<tr><th>Начало</th><th>Конец</th><th>тема</th><th>Аудитория</th></tr>";
                foreach($rasp as $r) {
           
               if ($r->timetable->group_id == $group_id) { 
               echo "<tr>";
               
                echo "<td>" . $r->start_at . "</td>";
                echo "<td>" . $r->finish_at . "</td>";

                echo "<td>". $r->timetable->block->name . "</td>";
                echo "<td>". $r->classroom->name . "</td>";

               echo "</tr>";}
           
            
        }
        echo "</table>";
    }
    
                }
