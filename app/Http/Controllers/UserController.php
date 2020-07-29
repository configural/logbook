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
                ->WhereBetween('start_at', [$start_at, $finish_at])
                ->orWhereBetween('finish_at', [$start_at, $finish_at])
                ->get();
        foreach($rasp as $r) {
           foreach($r->timetable->teachers as $teacher) {
               if ($teacher->id == $user_id) $busy = true;
           }
            
        }
        echo $busy;
    }
    
}
