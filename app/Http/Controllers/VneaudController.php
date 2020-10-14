<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vneaud;

class VneaudController extends Controller
{
    //
    
    
    function edit(Request $request) {
        dump($request);
    }
    
    function store(Request $request) {
        
        if ($request->id) :
                $vneaud = Vneaud::find($request->id);
            else:
                $vneaud = new Vneaud();
        endif;
        
        // добавить проверку количества часов
        
        $vneaud->fill($request->all());
       
        $vneaud->hours = $request->count * 0.5;
        
        $vneaud->save();
        return redirect(route('vneaud'));
        
    }
    
}
