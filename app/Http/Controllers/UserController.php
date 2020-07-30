<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;



class userController extends Controller
{
    //
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

        $user->save();
        return redirect('users');
    }
    
        
    public function is_busy($user_id, $date, $start_at, $finish_at) {
        $busy = false;
        /*$user_id = $request->user_id;
        $date = $request->date;
        $start_at = $request->start_at;
        $finish_at = $request->finish_at;*/

               
        $rasp = \App\Rasp::where('date', $date)
               
                ->get();
                //dump($rasp);
        
        echo "<p><strong>Преподаватель в этот день ведет следующие занятия:</strong></p>";
        echo "<table class='table table-bordered'>";
        echo "<tr><th>Препод.</th><th>Начало</th><th>Конец</th><th>группа</th><th>подгруппа</th><th>тема</th></tr>";
                foreach($rasp as $r) {
           foreach($r->timetable->teachers as $teacher) {
               if ($teacher->id == $user_id) { 
               echo "<tr>";
               echo "<td>" . $teacher->name . "</td>";
                echo "<td>" . $r->start_at . "</td>";
                echo "<td>" . $r->finish_at . "</td>";
                echo "<td>" . $r->timetable->group->name . "</td>";
                echo "<td>" . $r->timetable->subgroup . "</td>";
                echo "<td>". $r->timetable->block->name . "</td>";
               echo "</tr>";}
           }
            
        }
        echo "</table>";
        echo "<p>Укажите время занятия с учетом этого списка. При указании того же времени произойдет объединение групп (подгрупп) в расписании</p>";
    }
    
}
