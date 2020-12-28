<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LargeblockController extends Controller
{
    //
    
        public function show(Request $request) {
            
            $program_id = 0;
            if ($request->program_id) $program_id = $request->program_id;
                     
            $blocks = \App\Block::select('blocks.*')
                    ->join('disciplines', 'disciplines.id', '=', 'blocks.discipline_id')
                    ->join('discipline2program', 'discipline2program.discipline_id', '=', 'disciplines.id')
                    ->join('programs', 'discipline2program.program_id', '=', 'programs.id')
                    ->where('programs.id', $request->program_id)
                    ->get();
            
            return view('largeblocks', ['blocks' => $blocks, 'program_id' => $program_id]);
            
        }
    
        public function quick_update(Request $request) {
        $block = \App\Block::find($request->id);
        $block->fill($request->all());
        $block->save();
        return redirect('largeblocks?program_id=' . $request->program_id);
    }
    
}
