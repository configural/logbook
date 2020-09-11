<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rasp;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{
    //
    public function user_journal_list($user_id) {
        $user = \App\User::find($user_id);
        $journals = \App\Journal::where('teacher_id', $user_id)->orderBy('created_at', 'desc')->get();
        return view('report_journal_list', ['journals' => $journals, "user" => $user]);
        
    }
    
    public function view_journal($id) {
        $journal = \App\Journal::find($id);
        $user = \App\User::find($journal->teacher_id);
        $attendance = unserialize($journal->attendance);
       // dump($attendance);
        return view('report_journal_view', ['attendance' => $attendance, "journal" => $journal, "user" => $user]);
        
    }
    
    public function rasp_group(Request $request) {
        $group_id = $request->group_id;
        $date1 = $request->date1;
        $date2 = $request->date2;
        $template_file = "templates/temp_rasp.xlsx";
        //$spreadsheet = new Spreadsheet();
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template_file);

        $sheet = $spreadsheet->getActiveSheet();
        $group = \App\Group::find($group_id);
        $sheet->setCellValue('A1', 'Расписание занятий: ' . $group->name);
        $sheet->setCellValue('A3', $group->stream->programs->first()->name);
        
        $style1 = [
        'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
            'color' => ['argb' => 'FF000000'],
                 ],
            ],
        ];
        
        $style2 = [
        'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED,
            'color' => ['argb' => 'FF000000'],
                 ],
            ],
        ];

        
        $i = 5;
        $date = "";
        $pair = 0;
        $rasp = Rasp::select()->whereBetween('date', [$date1, $date2])->orderBy('date')->orderby('start_at')->get();
        
        foreach ($rasp as $r) {
            $pair++;
            if ($r->timetable->group_id == $group_id) {
                $i++;
                $sheet->getRowDimension($i)->setRowHeight(75);

                if ($date != $r->date) {
                    $sheet->setCellValue('A'.$i, date('d.m.Y', strtotime($r->date)));
                    $date = $r->date;
                    $sheet->getStyle('A'.$i.":E".$i)->applyFromArray($style1);
                } else {
                    $sheet->getStyle('B'.$i.":E".$i)->applyFromArray($style2);
                    
                }
                $sheet->setCellValue('b'.$i, substr($r->start_at, 0, 5) . chr(10) . substr($r->finish_at, 0, 5));
                if (isset($r->timetable->block->name)) $sheet->setCellValue('c'.$i, $r->timetable->block->name);
                $sheet->setCellValue('d'.$i, $r->classroom->name 
                        . chr(10) . $r->timetable->lesson_type->name
                        . chr(10) . $r->timetable->hours ." ч");
                
                $teachers = "";
                
                foreach($r->timetable->teachers as $teacher) 
                    { $teachers .= $teacher->fio() . chr(10);
                    //$teachers .= current(explode(" ", $teacher->name)) . chr(10);
                    }
                
                $sheet->setCellValue('e'.$i, $teachers);
                
                $sheet->getStyle('A'.$i.':E'.$i)->getAlignment()->setWrapText(true);
                /*$i++;
                if ($pair == 1) {
                $sheet->setCellValue('C'.$i, "Обед с 11:50 до 12:50");
                
                }*/
                

            } 
            $pair = 0;
        }
        
        $i+=2;
        $sheet->setCellValue('A'.$i, "Начальник отдела ДПО и ОУ");
        $sheet->setCellValue('D'.$i, "______________");
        $sheet->setCellValue('E'.$i, "Левенец Л.В.");
  
        $i+=2;
        $sheet->setCellValue('A'.$i, "Специалист отдела ДПО и ОУ");
        $sheet->setCellValue('D'.$i, "______________");
        $sheet->setCellValue('E'.$i, Auth::user()->fio());
        
        $writer = new Xlsx($spreadsheet);
        $filename =  $date1 . "-" . $date1 . "-rasp-" . $group->name . '.xlsx';
        $writer->save('reports/' . $filename);
        
        $html =  "Расписание сформировано. <p><a href='".$filename."' class='btn btn-success'>Скачать в формате Excel</a></p>";
        
        return view('info', ['html' => $html]);
    }
}
