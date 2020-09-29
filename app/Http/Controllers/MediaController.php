<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mediacontent;
use Illuminate\Database\Eloquent;
use Illuminate\Support\Facades\DB;

class MediaController extends Controller
{
    //
    
    function edit($id) {
        $media = Mediacontent::find($id);
        return view('mediaedit', ['media' => $media]);
    }
    
    function edit_my($id) {
        $media = Mediacontent::find($id);
        return view('media_myedit', ['media' => $media]);
    }


    function delete($id) {
        Mediacontent::find($id)->delete();
        DB::table('media2users')->where('media_id', $id)->delete();
        
        return redirect(route('media'));
        
    }

    
    function store(Request $request) {
        
        if ($request->id) {
            $media = Mediacontent::find($request->id);
        } else {        
            $media = new Mediacontent();
        }
        
        $media->fill($request->all());
        $media->save();
        
        DB::table('media2users')->where('media_id', $request->id)->delete();
        if (is_array($request->users)){
            foreach($request->users as $user) {
                $tmp = DB::table('media2users')->insert(['media_id' => $media->id, 'user_id' => $user]);
                }
            }
            
        if ($request->return) {
            return redirect(route($request->return));
        } else {
        return redirect(route('media'));
        }
    }
}
