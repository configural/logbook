<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    //
    public function user_journal_list($user_id) {
        $journals = \App\Journal::where('teacher_id', $user_id)->get();
        return view('report_journal_list', ['journals' => $journals]);
    }
}
