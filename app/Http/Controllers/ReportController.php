<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Rasp;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpWord;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;



class ReportController extends Controller
{
    //
    public function user_journal_list($user_id) {

        $user = \App\User::find($user_id);
        $journals = \App\Journal::select('journal.*')
                ->join('rasp', 'rasp.id', '=', 'journal.rasp_id')
                ->where('teacher_id', $user_id)
                ->orderBy('journal.created_at', 'desc')->get();
        return view('report_journal_list', ['journals' => $journals,  "user" => $user]);
        
    }
    
    public function view_journal($id) {
        $journal = \App\Journal::find($id);
        $user = \App\User::find($journal->teacher_id);
        $attendance = unserialize($journal->attendance);
        
        if ($journal->attestation) {
            $data = unserialize($journal->attestation);
            if (is_array($data)) {
            $attestation = $data;}
            } else {
            $attestation = Array();
        }
        //dump($attestation );
        return view('report_journal_view', ['attendance' => $attendance, 'attestation' => $attestation, "journal" => $journal, "user" => $user]);
        
    }
    
    /*
     * Формирование акта в Word
     */
    public function akt(Request $request) {
        $template = "templates/temp_akt.docx";
        $file = "akt/akt.docx";
        //$request->contract_id = 8;
        //$request->month = 1;
        //$request->year = 2021;
        //$request->paid = 0;
        //$request->akt_date = '25.01.2021';
        //$request->rektor = "Беляков Н.Ф.";
        $months = Array("", "январь", "февраль", "март", "апрель", "май", "июнь", "июль", "август", "сентябрь", "октябрь", "ноябрь", "декабрь");
        
        $finance_source = ["субсидий", "приносящей доход деятельности"];
        
        $dogovor = \App\Contract::find($request->contract_id);
        $date_month = $request->year . "-" . sprintf("%02d", $request->month);
 
        // подсчитываем часы в месяце
        $hours = \App\Timetable::select(['timetable.hours' ])
                ->join('groups', 'groups.id', '=', 'timetable.group_id')
                ->join('rasp', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->where('teachers2timetable.contract_id', '=', $request->contract_id)
                ->where('rasp.date', 'like' , $date_month . '%') 
                ->where('groups.paid', $request->paid)
                ->sum('hours'); 

        // аудиторные часы
        $aud_h = \App\Timetable::select(['timetable.hours'])
                ->join('groups', 'groups.id', '=', 'timetable.group_id')
                ->join('rasp', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->where('teachers2timetable.contract_id', '=', $request->contract_id)
                ->where('rasp.date', 'like' , $date_month . '%')   
                ->whereIn('timetable.lessontype', [1,2,11,15])
                ->where('groups.paid', $request->paid)
                ->sum('hours'); 
        // часы аттестации, экзамены
        $att_h = \App\Timetable::select(['timetable.hours'])
                ->join('groups', 'groups.id', '=', 'timetable.group_id')
                ->join('rasp', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->where('teachers2timetable.contract_id', '=', $request->contract_id)
                ->where('rasp.date', 'like' , $date_month . '%')   
                ->whereIn('timetable.lessontype', [3,4,5,16,17,18,19])
                ->where('groups.paid', $request->paid)
                ->sum('hours'); 
        // часы аттестации, экзамены
        $tests_h = \App\Timetable::select(['timetable.hours'])
                ->join('groups', 'groups.id', '=', 'timetable.group_id')
                ->join('rasp', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->where('teachers2timetable.contract_id', '=', $request->contract_id)
                ->where('rasp.date', 'like' , $date_month . '%')   
                ->whereIn('timetable.lessontype', [9,10])
                ->where('groups.paid', $request->paid)
                ->sum('hours'); 

        // Рецензирование ИР, ВКР
        $rec_vkr_h = \App\Timetable::select(['timetable.hours'])
                ->join('groups', 'groups.id', '=', 'timetable.group_id')
                ->join('rasp', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->where('teachers2timetable.contract_id', '=', $request->contract_id)
                ->where('rasp.date', 'like' , $date_month . '%')   
                ->whereIn('timetable.lessontype', [12, 14])
                ->where('groups.paid', $request->paid)
                ->sum('hours');         
        
        // Руководство ИР, ВКР
        $ruk_vkr_h = \App\Timetable::select(['timetable.hours'])
                ->join('groups', 'groups.id', '=', 'timetable.group_id')
                ->join('rasp', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->where('teachers2timetable.contract_id', '=', $request->contract_id)
                ->where('rasp.date', 'like' , $date_month . '%')   
                ->whereIn('timetable.lessontype', [13])
                ->where('groups.paid', $request->paid)
                ->sum('hours');         
        
        //$vneaud_h = \App\Vneaud::select()
        $aud_hours = "";
        if ($aud_h) {$aud_hours .= "Лекции, практика, вебинары, консультации: " . $aud_h . " ч.<w:br/>";}
        if ($tests_h) {$aud_hours .= "Проверка тестов и практических работ: " . $tests_h . " ч.<w:br/>";}
        if ($att_h) {$aud_hours .= "Экзамены, итоговая аттестация: " . $att_h . " ч.<w:br/>"; }
        if ($rec_vkr_h) {$aud_hours .= "Рецензирование ИР, ВКР: " . $rec_vkr_h . " ч.<w:br/>"; }
        if ($att_h) {$aud_hours .= "Руководство ВКР: " . $ruk_vkr_h . " ч.<w:br/>"; }
        
       /*
         * 
        */

       
        // занятия по темам
        $blocks_to_word = "";
        $blocks = \App\Timetable::select(['blocks.name', 'timetable.hours', 'timetable.lessontype'])
                ->join('groups', 'groups.id', '=', 'timetable.group_id')
                ->join('rasp', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('teachers2timetable', 'teachers2timetable.timetable_id', '=', 'timetable.id')
                ->join('blocks', 'timetable.block_id', '=', 'blocks.id')
                ->where('teachers2timetable.contract_id', '=', $request->contract_id)
                ->where('rasp.date', 'like' , $date_month . '%')   
                ->where('groups.paid', $request->paid)
                ->get();
                //->toSql(); 
        
       // dd($blocks);
                foreach($blocks as $b) {
                     $blocks_to_word .=  "- " . str_limit($b->name, 70, '...') . " (" . \App\LessonType::find($b->lessontype)->name . ", ". $b->hours. " ч)<w:br/>";
                }

        //lessontypes
                
        // всего начислено
         $total_price = $dogovor->price * $hours;
         $strah = $total_price * 0.271;
         $total_strah_price = $total_price + $strah;
         $uplata = $total_price - $total_price * 0.13;
         
        if ($dogovor) {
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($template);
        $templateProcessor->setValue('dogovor_n', $dogovor->name);
        $templateProcessor->setValue('dogovor_ot', \Logbook::normal_date($dogovor->date));
        $templateProcessor->setValue('username', $dogovor->user->name);
        $templateProcessor->setValue('akt_number', $dogovor->name);
        $templateProcessor->setValue('akt_date', \Logbook::normal_date($request->akt_date));
        $templateProcessor->setValue('month', $months[$request->month]);
        $templateProcessor->setValue('year', $request->year);
        $templateProcessor->setValue('hours', $hours);
        $templateProcessor->setValue('lessontypes', $aud_hours);
        $templateProcessor->setValue('disciplines', $blocks_to_word);
       // $templateProcessor->setValue('attestation', $attestation_hours);
        $templateProcessor->setValue('hour_price', $dogovor->price);
        $templateProcessor->setValue('lessons', $blocks_to_word);
        $templateProcessor->setValue('total_price', $total_price);
        $templateProcessor->setValue('total_price_string', \Logbook::num2str($total_price));
        $templateProcessor->setValue('strah', $strah);
        $templateProcessor->setValue('total_strah_price', $total_strah_price);
        $templateProcessor->setValue('total_strah_price_string', \Logbook::num2str($total_strah_price));
        $templateProcessor->setValue('uplata', $uplata);
        $templateProcessor->setValue('uplata_string', \Logbook::num2str($uplata));
        $templateProcessor->setValue('strah_string', \Logbook::num2str($strah));
        $templateProcessor->setValue('finance_source', $finance_source[$request->paid]);
        $templateProcessor->setValue('usernm', $dogovor->user->fio());
        $templateProcessor->setValue('rektor', $request->rektor);
        $templateProcessor->saveAs($file);
        
        $headers = array('Content-Type: application/docx');
        return response()->download($file, "Акт-" . $dogovor->user->fio() . "-" . $request->year . "-" . $months[$request->month] . ".docx", $headers);
        }
        else {echo "Договор $request->contract_id не найден";}
        
    }
    
    /*
     * Формирование расписания в Excel
     */
    
    public function rasp_group(Request $request) { 
        $group_id = $request->group_id;
        $date1 = $request->date1;
        $date2 = $request->date2;
        $template_file = "templates/temp_raspOK.xlsx";
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($template_file);

        $sheet = $spreadsheet->getActiveSheet();
        $group = \App\Group::find($group_id);
        $sheet->setCellValue('C6', 'Расписание занятий: Группа ' . $group->name);
        $sheet->setCellValue('C7', date('d.m.Y', strtotime($date1)) . " — " . date('d.m.Y', strtotime($date2)));
        $sheet->setCellValue('A8', $group->stream->programs->first()->name);
        $sheet->setCellValue('A8', $group->stream->programs->first()->name);
        
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

        
        $style3 = [
        'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOTTED,
            'color' => ['argb' => 'FF000000'],
                 ],
            ],
         'font' => [
             'bold' => false,
         ]
        ];
        
        $i = 10;
        $date = "";
        
        $rasp = Rasp::select()->whereBetween('date', [$date1, $date2])->orderBy('date')->orderby('start_at')->get();
        
        foreach ($rasp as $r) {
        
            $pair = 0;    
            if ($r->timetable->group_id == $group_id) {
                $i++;
                $sheet->getRowDimension($i)->setRowHeight(35);

                if ($date != $r->date) {
                    //dump($r->date);
                    $pair ++;
                    $sheet->setCellValue('A'.$i, date('d.m.Y', strtotime($r->date)) . chr(10) . Rasp::weekday($r->date));
                    $date = $r->date;
                    $sheet->getStyle('A'.$i.":E".$i)->applyFromArray($style1);
                } else {
                    $sheet->getStyle('B'.$i.":E".$i)->applyFromArray($style2);
                    
                }
                $sheet->setCellValue('b'.$i, substr($r->start_at, 0, 5) . chr(10) . substr($r->finish_at, 0, 5));
                if (isset($r->timetable->block->name)) {
                if (strlen($r->timetable->block->name) >= 90) {
                    $r->timetable->block->name = str_limit($r->timetable->block->name, 90, '[...]');
                }
                if (isset($r->timetable->block->name)) {$sheet->setCellValue('c'.$i, $r->timetable->block->name);}
                $sheet->setCellValue('d'.$i, $r->timetable->lesson_type->name
                        . chr(10) . $r->timetable->hours ." ч");
                
                $teachers = "";
                
                foreach($r->timetable->teachers as $teacher) {
                    $teachers .= $teacher->fio() . chr(10);                   
                    }
                
                $sheet->setCellValue('e'.$i, $r->classroom->name . chr(10) . $teachers);
               
                } else {
                     $sheet->setCellValue('c'.$i, $r->timetable->lesson_type->name);
                     $sheet->setCellValue('d'.$i, "");
                     $sheet->setCellValue('e'.$i, $r->classroom->name);
                    
                }
                 $sheet->getStyle('A'.$i.':E'.$i)->getAlignment()->setWrapText(true);
                    if ($pair == 1) {
                    $i++;
                    //dump($pair);
                    $sheet->setCellValue('C'.$i, "Перерыв на обед: " . $request->obed);
                    $sheet->getStyle('B'.$i.":E".$i)->applyFromArray($style3);
                
                }

                
                
            } 
        
        }
        
        $i+=2;
        $sheet->setCellValue('A'.$i, "Начальник отдела ДПО и ОУ ____________ Левенец Л.В.");
  
        $i+=2;
        $sheet->setCellValue('A'.$i, "Специалист отдела ДПО и ОУ __________ " . Auth::user()->fio());
        
        $writer = new Xlsx($spreadsheet);
        $filename =  $date1 . "-" . $date1 . "-rasp-" . $group->name . '.xlsx';
        $writer->save('reports/' . $filename);
        
        $html =  "Расписание сформировано. <p><a href='".$filename."' class='btn btn-success'>Скачать в формате Excel</a></p>";
        
        return view('info', ['html' => $html]);
    }

    
    
    
    
    function rasp_kafedra(Request $request) {
        $request->date1 ? $date1 = $request->date1 : $date1 = date("Y-m-d");
        $request->date2 ? $date2 = $request->date2 : $date2 = Carbon::now()->addMonth()->format("Y-m-d");
        $freelance = $request->freelance;
        $users = \App\User::where('department_id', $request->department_id)
                ->where('freelance', $freelance)
                ->orderBy('name')->get();
        return view('report_rasp_kafedra', ['users' => $users, 'date1' => $date1, 'date2' => $date2, 'freelance' => $freelance, 'department_id' => $request->department_id]);
    }

//табель штатных преподавателей    
    function tabel(Request $request) {
        $request->date1 ? $date1 = $request->date1 :  $date1 = Carbon::now()->subMonth()->format("Y-m-d");
        $request->date2 ? $date2 = $request->date2 :  $date2 = date("Y-m-d");
        $users = \App\User::where('department_id', $request->department_id)->where('freelance', 0)->orderBy('name')->get();
        
        return view('report_tabel', ['users' => $users, 'date1' => $date1, 'date2' => $date2, 'department_id' => $request->department_id]);
       
    }

// табель внештатных пеподавателей
    function tabel_freelance(Request $request) {
        $request->date1 ? $date1 = $request->date1 :  $date1 = date("Y-m-")."01";
        $request->date2 ? $date2 = $request->date2 :  $date2 = \Carbon\Carbon::now()->endOfMonth()->toDateString();
        

        
        $users = \App\User::where('freelance', 1)->orderBy('name')->get();
        return view('report_tabel_freelance', ['users' => $users, 'date1' => $date1, 'date2' => $date2, 'form_id' => $request->form_id]);
    }


    
    function no_journal(Request $request) {
      /*  $journal = \App\Rasp::select()->where('date', '<', date('Y-m-d'))
                ->join('timetable', 'timetable.rasp_id', '=', 'rasp.id')
                ->join('journal', 'journal.rasp_id', '=', 'rasp.id')
                ->where('journal.attendance', '=', 'a:0:{}')
                ->orWhereNull('journal.attendance')
                ->get();
           //dump($journal);     
        return view('no_journal', ['journal' => $journal]);*/
        
        $rasp =  \App\Rasp::select()->where('date', '<', date('Y-m-d'))->get();
        
        return view('no_journal', ['rasp' => $rasp]);
    }
    
    
    function themes(Request $request) {
        if (isset($request->department_id)) {
            $department_id = $request->department_id;
        } else {
            $department_id = Auth::user()->department_id;
        }
        
        $date1 = $request->date1;
        $date2 = $request->date2;
        $year = $request->year;
        
        $disciplines = \App\Timetable::select('disciplines.name')
                ->join('rasp', 'rasp.id', '=', 'timetable.id')
                ->join('blocks', 'timetable.block_id', '=', 'blocks.id')
                ->join('disciplines', 'disciplines.id', '=', 'blocks.discipline_id')
                ->distinct('disciplines.name')
                ->where('disciplines.department_id', '=', $department_id)
                ->orWhere('blocks.department_id', '=', $department_id)
                ->orderby('disciplines.name')
                ->get();
        
        
        return view ('report_themes', ['department_id' => $department_id, 'date1' => $date1, 'date2' => $date2, 'year'=> $year, 'disciplines' => $disciplines]);
    }
    
   
}
