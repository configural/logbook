<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Test;
use App\Question;
use DOMDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TestController extends Controller
{
    
    function edit_test($id) {
        $test = Test::find($id);
        return view('testedit', ['test' => $test]);
    }
    //
    function store_test(Request $request) {
        if ($request->id) {
            $test = Test::find($request->id);
        }   else {
            $test = new Test();
        }
        $test->fill($request->all());
        
        // привязка к потокам
        
       // dump($request->bind);
        DB::table('tests2streams')->where('test_id', $request->id)->delete();
        if (is_array($request->bind)){
            foreach($request->bind as $stream_id) {
                $tmp = DB::table('tests2streams')->insert(['test_id' => $request->id, 'stream_id' => $stream_id, 'user_id' => Auth::user()->id]);
                }
            }
        
       
        $test->save();
        if ($request->id) {
            return redirect(route('tests'));
        } else {
            return redirect('test/' . $test->id . '/questions');
        }
    }
    
    
    function show_questions($id) {
        $test = Test::find($id);
        return view('testquestions', ['test' => $test]);
    }
    

    function edit_question($id) {
        $question = Question::find($id);
        return view('questionedit', ['question' => $question]);
    }

    function store_question (Request $request) {
      if ($request->id) {
            $question = Question::find($request->id);
        } else {
            $question = new Question();
        }

        $question->fill($request->all());
        
        // summernote start
        $detail = $request->name;
        libxml_use_internal_errors(true);
        $dom = new \domdocument();
        $dom->loadHtml($detail, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        
        
        $nodeHead=$dom->createElement("head");
        $nodeMeta=$dom->createElement('meta');
        $dom->insertBefore($nodeHead, $dom->firstChild);
        $nodeMeta->setAttribute ("http-equiv","Character");
        $nodeMeta->setAttribute ("content","ISO-8859-1");
      
        $nodeHead->appendChild($nodeMeta);
        $nodeMeta=$dom->createElement('meta');
        $nodeMeta->setAttribute ("http-equiv","Content-Type");
        $nodeMeta->setAttribute ("content","text/html; charset=ISO-8859-1");
      
        $nodeHead->appendChild($nodeMeta);
        
        $images = $dom->getElementsByTagName('img');
        
        
        

        foreach ($images as $count => $img) {
            $data = $img->getAttribute('src');
            
            if (str_contains($data, 'base64')) {

                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);

                $data = base64_decode($data);

                $image_name= "images/" . $request->id . "_" . time().$count.'.png';
                $path = public_path() . "/" . $image_name;

                file_put_contents($path, $data);

                $img->removeAttribute('src');
                $img->setAttribute('src', url('/') ."/" . $image_name);
           }
        }
     $detail = $dom->savehtml();
     $detail = strip_tags($detail, "<p><a><img><br><h1><h2><h3><h4><table><tr><td><thead><tbody><span><strong><b><i><ul><ol><li>");
        // summernote finish
        
        $question->name = $detail;
        $question->save();
        return redirect(url('/') . '/test/' . $request->test_id . '/questions#' . $question->id);
    }
}
