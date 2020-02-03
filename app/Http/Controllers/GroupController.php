<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Group;

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
}
