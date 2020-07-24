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
    
}
