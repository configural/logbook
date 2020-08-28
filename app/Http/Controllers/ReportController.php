<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rasp;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportController extends Controller
{
    //
    public function user_journal_list($user_id) {
        $journals = \App\Journal::where('teacher_id', $user_id)->orderBy('created_at', 'desc')->get();
        return view('report_journal_list', ['journals' => $journals]);
        
    }
    
    public function view_journal($id) {
        $journal = \App\Journal::find($id);
        $attendance = unserialize($journal->attendance);
       // dump($attendance);
        return view('report_journal_view', ['attendance' => $attendance]);
        
    }
    
    public function rasp_group(Request $request) {
        $group_id = $request->group_id;
        $date = $request->date;
        $template_file = "templates/temp_rasp.xlsx";
        //$spreadsheet = new Spreadsheet();
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template_file);

        $sheet = $spreadsheet->getActiveSheet();
        
        $group = \App\Group::find($group_id);
        dump($group);
        $sheet->setCellValue('B2', $group->name);
        $sheet->setCellValue('B3', $date);
        $i = 5;
        $rasp = Rasp::select()->where('date', $date)->get();
        foreach ($rasp as $r) {
            if ($r->timetable->group_id == $group_id) {
                $i++;
                $sheet->setCellValue('A'.$i, $r->start_at);
                $sheet->setCellValue('B'.$i, $r->finish_at);
                $sheet->setCellValue('C'.$i, $r->timetable->block->name);
                $sheet->setCellValue('D'.$i, $r->timetable->lesson_type->name);
            }
        }
        

        $writer = new Xlsx($spreadsheet);
        $filename =  $date . "-rasp-" . $group->name . '.xlsx';
        $writer->save('reports/' . $filename);
        
        echo "<a href='".$filename."'>Скачать</a>";
    }
}
