<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;
use App\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

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
        $group->paid = $request->paid; // платная?
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
        $group->paid = $request->paid; // платная?
        $group->subgroup_count = $request->subgroup_count; // количество подгрупп
        $group->save();
        return redirect('stream/'.$group->stream_id.'/edit');
    }
    
    public function add_empty_students(Request $request) {
        for ($i = 0; $i < $request->count; $i++) {
            $student = new Student;  
            if ($i%2) {$student->subgroup = 2;}
            else {$student->subgroup = 1;}
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
            $sono = (int)trim($item[0]);
            $secname = trim($item[1]);
            $name = trim($item[2]);
            $fathername = trim($item[3]);
            if (($sono >= 0 and $sono<=9999) and (count($item) == 4)) {
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
               // dump($problems);
            }
        }   
       if (count($problems)) {
                    $message = "<span style='font-weight: bold; color: red'>Выявлены ошибки форматирования текста, загрузка не удалась. Текст автоматически исправлен. Попробуйте нажать кнопку ЗАГРУЗИТЬ СПИСОК еще раз.</span>";
                    
                }  else  {
                    $message = "Успешно добавлено $count записей";
                }
        return view('groupaddstudents', ['id' => $group_id, 'problems' => $problems, 'message' => $message] );
    }

        public function group_busy($group_id, $date, $start_at, $finish_at) {
                $busy = false;
                echo "<p><strong><span class='red'>Группа " . \App\Group::find($group_id)->name . "</span></strong></p>";             
                $rasp = \App\Rasp::selectRaw('rasp.*, groups.name as group_name')
                        ->join('timetable', 'timetable.rasp_id', '=', 'rasp.id')
                        ->join('groups', 'groups.id', '=', 'timetable.group_id')
                        ->where('groups.id', $group_id)
                        ->where('rasp.date', $date)
                        ->get();
                        
                foreach($rasp as $r) {
    
               $cross = false;
               if (     ($start_at>=$r->start_at && $finish_at<=$r->finish_at) or
                        ($start_at<=$r->start_at && $finish_at>=$r->finish_at) or
                        ($finish_at>=$r->start_at && $finish_at<=$r->finish_at) or
                        ($start_at>=$r->start_at && $start_at<=$r->finish_at)
                       )
               {$cross = true;}                            

                       if ($r->timetable->group_id == $group_id) { 
                        echo "<div ";
                            if ($cross == true) echo " class='cross' ";
                        echo">";
                        echo "" . str_limit($r->start_at,5,'') . " - ";
                        echo "" . str_limit($r->finish_at,5,'') . " ";
                        echo " ". $r->classroom->name . "</td>";
                       echo "</div>";}
                }
            }

        public function import_asus(Request $request) {
/*           
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
            $sheet = $spreadsheet->getActiveSheet();
            dump($sheet);
               */ 
            return view('info', ['html' => 'Пока в разработке']);
            
            }
            
}
