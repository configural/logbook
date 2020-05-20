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
        $group->save();
        return redirect('stream/'.$group->stream_id.'/edit');
    }
    
    public function add_students(Request $request) {
        $group_id = $request->group_id;
        $divider = stripcslashes($request->divider);
        $import = str_replace($divider, ' ', $request->import); 
        $import = preg_replace("/ {2,}/", " ", $import);
        $strings = explode("\r\n", $import);
        $problems = array();
        $message = "";
        $count = 0;
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
                    $student->save();
                    $count++;
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
}
