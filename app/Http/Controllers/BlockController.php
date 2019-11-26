<?php

namespace App\Http\Controllers;
use App\Block;
use Illuminate\Http\Request;

class BlockController extends Controller
{
    //
        //
    
    public function view(Request $request) {
        $block = Block::find($request->id);
        return view('block', ['block' => $block]);
    }
    
    
    public function add(Request $request) {
        $block = new Block;
        $block->name = $request->name;
        $block->active = $request->active;
        $block->discipline_id = $request->discipline_id;
        $block->save();
        return redirect('discipline/'.$block->discipline_id);
        
    }
    
    public function edit(Request $request) {
        $id = $request->id;
        $block = Block::find($id);
        return view('blockedit', ['block' => $block]);
        
    }
    
    public function store(Request $request) {
        $block = Block::find($request->id);
        $block->name = $request->name;
        $block->active = $request->active;
        $block->save();
        return redirect('discipline/'.$block->discipline_id);
    }
}
