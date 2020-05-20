<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Stream;
use App\Group;
use App\Program;
use App\Discipline;
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
    public function bind_program(Request $request) {
        //dump($request);
        DB::table('programs2stream')->insert(["stream_id" => $request->stream_id, "program_id" => $request->program_id]);
        $this->make_workload($request->stream_id, $request->program_id);
        return redirect('stream/'.$request->stream_id.'/edit');

    }
    public function unbind_program($stream_id, $program_id) {
        DB::table('programs2stream')
                ->where('stream_id', $stream_id)
                ->where('program_id', $program_id)
                ->limit(1)
                ->delete();
        return redirect('stream/'.$stream_id.'/edit');
    }
        
    private function make_workload($stream_id, $program_id) {
        $groups = Group::where('stream_id', $stream_id)->get();
        $programs = Program::where('id', $program_id)->get();
        
        foreach($groups as $group) {
            $group_id = $group->id;
            foreach($programs as $program) {
               foreach($program->disciplines as $discipline) {
                    foreach($discipline->blocks as $block) {
                    //   dump($block->name);
                       
                       $workload = ["group_id" => $group_id, "block_id" => $block->id];
                       //dump($workload);
                       DB::table('timetable')->insert($workload);
                   }
               }

            }
        }
        
    }
        
    

}