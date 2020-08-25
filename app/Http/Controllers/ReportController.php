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
        $journals = \App\Journal::where('teacher_id', $user_id)->get();
        return view('report_journal_list', ['journals' => $journals]);
    }
    
    public function rasp_group($group_id, $date) {
        
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Привет мир!');
        $i = 1;
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
        $writer->save('reports/hello world.xlsx');
    }
}
