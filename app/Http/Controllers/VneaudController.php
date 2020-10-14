<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vneaud;

class VneaudController extends Controller
{
    //
    
    
    function edit(Request $request) {
        $vneaud = Vneaud::find($request->id);
        return view('vneaudedit', ['vneaud' => $vneaud]);
    }

    function delete(Request $request) {
        Vneaud::find($request->id)->delete();
        return redirect(route('vneaud'));
    }
    
    
    function store(Request $request) {
        
        if ($request->id) :
                $vneaud = Vneaud::find($request->id);
            else:
                $vneaud = new Vneaud();
        endif;
        
        // добавить проверку количества часов
        
        $vneaud->fill($request->all());
       
        if ($request->count) :
        $vneaud->hours = $request->count * 0.5;
        endif;
       
        $vneaud->save();
        return redirect(route('vneaud'));
        
    }
    
}
