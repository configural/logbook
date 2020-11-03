<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Test;
use App\Question;

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
        
        $question->save();
        return redirect(url('/') . '/test/' . $request->test_id . '/questions#' . $question->id);
    }
}
