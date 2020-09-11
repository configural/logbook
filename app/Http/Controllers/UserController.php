<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;



class userController extends Controller
{
    //
    
    public function update_profile(Request $request) {
        $errors = Array();
        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        
        if ($request->password) {
        if ($request->password == $request->confirm_password) {
            $user->password = bcrypt($request->password);
        } else {$errors[] = "Введенные пароли не совпадают"; }}
        if (count($errors)) {
            return view('info', ['html' => implode("<br/>", $errors)]);
        } else {
            $user->save();
            return redirect(route('home'));
        }
    }


    public function showUsers() {
        // возвращает список пользователей
        return view('users');
    }

    public function add(Request $request) {
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->department_id = $request->department_id;
        $user->freelance = $request->freelance;
        $user->save();
        return view('users');
        
    }
    
    public function edit(Request $request) {
        $id = $request->id;
        $user = User::find($id);
        return view('useredit', ['user' => $user]);
        
    }
    
    public function store(Request $request) {
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->department_id = $request->department_id;
        $user->freelance = $request->freelance;
        $user->save();
        return redirect('users');
    }
    
        
    public function teacher_busy($user_id, $date, $start_at, $finish_at) {
        $busy = false;
              
        $rasp = \App\Rasp::where('date', $date)->get();
        echo "<p><strong>Преподаватель в этот день ведет следующие занятия:</strong></p>";
        echo "<table class='table table-bordered'>";
        echo "<tr><th>Начало</th><th>Конец</th><th>Группа [подгруппа]</th><th>Аудитория</th></tr>";
                foreach($rasp as $r) {
           foreach($r->timetable->teachers as $teacher) {
               if ($teacher->id == $user_id) { 
               echo "<tr>";
               
                echo "<td>" . $r->start_at . "</td>";
                echo "<td>" . $r->finish_at . "</td>";
                echo "<td>" . $r->timetable->group->name . " [" .$r->timetable->subgroup . "]</td>";
                echo "<td>". $r->classroom->name . "</td>";
               echo "</tr>";}
           }
            
        }
        echo "</table>";
        echo "";
    }
    
}
