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
    
    // добавляем новый тематический блок в дисциплину
    public function add(Request $request) {
        $block = new Block;
        $block->name = $request->name; // название
        $block->l_hours = $request->l_hours; // лекционные часы
        $block->p_hours = $request->p_hours; // часы практики
        $block->s_hours = $request->s_hours; // часы самост. работы
        $block->active = $request->active; // опубликовано?
        $block->discipline_id = $request->discipline_id; // ид дисциплины, к которому привязваны
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
        $block->name = $request->name; // название
        $block->l_hours = $request->l_hours; // лекционные часы
        $block->p_hours = $request->p_hours; // часы практики
        $block->s_hours = $request->s_hours; // часы самост. работы
        $block->active = $request->active; // опубликовано?
        $block->save();
        return redirect('discipline/'.$block->discipline_id);
    }
    
    public function delete($id) {
        $block = Block::find($id);
        $discipline_id = $block->discipline_id;
        $block->delete();
        return redirect('discipline/'.$discipline_id);    }  
}
