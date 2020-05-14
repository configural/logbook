<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stream;
use DB;


class StreamController extends Controller
{
    //
    public function add(Request $request) {
        $stream = new Stream;
        $stream->name = $request->name;
        $stream->date_start = $request->date_start;
        $stream->date_finish = $request->date_finish;
        $stream->year = $request->year;
        $stream->save();
      //  $id = DB::table('programs2stream')->insertGetId(['program_id' => $request->program_id, 'stream_id' => $stream->id]);
      //  dump($id);
        
        return view('streams');
        
    }
    
    public function edit(Request $request) {
        $id = $request->id;
        $stream = Stream::find($id);
        return view('streamedit', ['stream' => $stream]);
        
    }
    
    public function store(Request $request) {
        $stream = Stream::find($request->id);
        $stream->name = $request->name;
        $stream->date_start = $request->date_start;
        $stream->date_finish = $request->date_finish;
        $stream->year = $request->year;
        $stream->save();
        

        
        
        return view('streams');
    
}
}