<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vneaud;
use Illuminate\Support\Facades\Auth;

class VneaudController extends Controller
{
    //
    
    
    function edit(Request $request) {
        $vneaud = Vneaud::find($request->id);
        return view('vneaudedit', ['vneaud' => $vneaud]);
    }

    function delete(Request $request) {
        Vneaud::find($request->id)->delete();
               
        if (in_array(Auth::user()->role_id, [4])) :
            return redirect(route('vneaud'));
        else :
            return redirect(route('vneaudmy'));
        endif;
        
    }
    
    
    function store(Request $request) {
        
        if ($request->lessontype_id == 13) {
            $hours = 10;
        }
        else {
            $hours = 0.5;
        }
        
        if ($request->id) :
                $vneaud = Vneaud::find($request->id);
            else:
                $vneaud = new Vneaud();
        endif;
        
        // добавить проверку количества часов
        
        $vneaud->fill($request->all());
       
        if ($request->count) :
        $vneaud->hours = $request->count * $hours;
        endif;
       
        $vneaud->save();
        
        if (in_array(Auth::user()->role_id, [3, 4, 5, 6])) :
            return redirect(route('vneaud'));
        else :
            return redirect(route('vneaudmy'));
        endif;
    }
    
}
